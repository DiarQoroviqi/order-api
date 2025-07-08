<?php

namespace App\Services\Discount;

use App\Models\Order;

class LoyaltyDiscount extends DiscountHandler
{
    protected function apply(Order $order, float $subtotal, array &$appliedDiscounts): float
    {
        $orderCount = $order->customer->orders()->count();
        if ($orderCount > 5) {
            $discount = $subtotal * 0.05;
            $appliedDiscounts[] = ['name' => 'Loyalty', 'amount' => round($discount, 2)];
            return $subtotal - $discount;
        }
        return $subtotal;
    }
}
