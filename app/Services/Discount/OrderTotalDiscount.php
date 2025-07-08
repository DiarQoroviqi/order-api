<?php

namespace App\Services\Discount;

use App\Models\Order;

class OrderTotalDiscount extends DiscountHandler
{
    protected function apply(Order $order, float $subtotal, array &$appliedDiscounts): float
    {
        if ($subtotal > 100) {
            $discount = $subtotal * 0.10;
            $appliedDiscounts[] = ['name' => 'Order > 100€', 'amount' => round($discount, 2)];
            return $subtotal - $discount;
        }
        return $subtotal;
    }
}
