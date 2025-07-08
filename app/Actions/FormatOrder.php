<?php

namespace App\Actions;

use App\Models\Order;
use App\Services\Discount\DiscountService;

class FormatOrder
{
    public function __construct(
        protected DiscountService $discountService,
    ) {}

    public function handle(Order $order): array
    {
        $order->loadMissing('products');

        $subtotal = $order->products->sum(fn ($product) =>
            $product->pivot->quantity * $product->price
        );

        $discounted = $this->discountService->apply($order, $subtotal);

        return [
            'order_id' => $order->id,
            'products' => $order->products->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'total' => round($product->pivot->quantity * $product->price, 2),
            ]),
            'subtotal' => $discounted['subtotal'],
            'discounts' => $discounted['discounts'],
            'total' => $discounted['total'],
        ];
    }
}
