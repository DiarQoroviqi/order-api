<?php

namespace App\Actions;

use App\Models\Order;

class AddProductToOrder
{
    public function handle(Order $order, int $productId, int $quantity): void
    {
        $existing = $order->products()->where('product_id', $productId)->first();

        if ($existing) {
            $order->products()->updateExistingPivot($productId, [
                'quantity' => $existing->pivot->quantity + $quantity,
            ]);
        } else {
            $order->products()->attach($productId, [
                'quantity' => $quantity,
            ]);
        }
    }
}
