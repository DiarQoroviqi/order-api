<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\SpecialDay;
use App\Services\Discount\DiscountService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscountServiceTest extends TestCase
{
    use RefreshDatabase;

    protected DiscountService $discountService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->discountService = app(DiscountService::class);

        SpecialDay::factory()->create(['date' => now()->toDateString()]);
    }

    public function test_it_applies_only_order_over_100_discount()
    {
        $customer = Customer::factory()->create();
        Order::factory()->create(['customer_id' => $customer->id]); // 1 past order

        \DB::table('special_days')->truncate();

        $order = Order::factory()->create(['customer_id' => $customer->id]);

        $product = Product::factory()->create(['price' => 60]);
        $order->products()->attach($product->id, ['quantity' => 2]);

        $discountService = new DiscountService();
        $subtotal = 120;
        $result = $discountService->apply($order, $subtotal);

        $this->assertEquals(120.00, $result['subtotal']);
        $this->assertCount(1, $result['discounts']); // Only 1 discount should apply
        $this->assertEquals('Order > 100€', $result['discounts'][0]['name']);
        $this->assertEquals(12.00, $result['discounts'][0]['amount']);
        $this->assertEquals(108.00, $result['total']);
    }

    public function test_it_applies_loyalty_discount()
    {
        $customer = Customer::factory()->create();

        Order::factory()->count(6)->for($customer)->create();

        $order = Order::factory()->for($customer)->create();

        $product = Product::factory()->create(['price' => 100]);
        $order->products()->attach($product, ['quantity' => 1]);

        $subtotal = 100;

        $result = $this->discountService->apply($order, $subtotal);

        $discountNames = collect($result['discounts'])->pluck('name');
        $this->assertTrue($discountNames->contains('Loyalty'));
    }

    public function test_it_applies_special_day_discount()
    {
        $customer = Customer::factory()->create();
        $order = Order::factory()->for($customer)->create(['created_at' => now()]);

        $product = Product::factory()->create(['price' => 50]);
        $order->products()->attach($product, ['quantity' => 1]);

        $subtotal = 50;

        $result = $this->discountService->apply($order, $subtotal);

        $discountNames = collect($result['discounts'])->pluck('name');
        $this->assertTrue($discountNames->contains('Special Day'));
    }

    public function test_it_applies_all_discounts_in_order()
    {
        $customer = Customer::factory()->create();
        Order::factory()->count(6)->for($customer)->create();

        $order = Order::factory()->for($customer)->create(['created_at' => now()]);

        $product = Product::factory()->create(['price' => 150]);
        $order->products()->attach($product, ['quantity' => 1]);

        $subtotal = 150;

        $result = $this->discountService->apply($order, $subtotal);

        $discountNames = collect($result['discounts'])->pluck('name');

        $this->assertEqualsCanonicalizing([
            'Order > 100€',
            'Loyalty',
            'Special Day'
        ], $discountNames->all());
    }
}
