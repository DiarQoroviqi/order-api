<?php

namespace App\Actions;

use App\Models\Customer;

class ListCustomerOrders
{
    public function __construct(
        protected FormatOrder $formatter,
    ){}

    public function handle(Customer $customer): array
    {
        $orders = $customer->orders()->with('products')->get();

        return $orders->map(
            fn($order) => $this->formatter->handle($order)
        )->toArray();
    }
}
