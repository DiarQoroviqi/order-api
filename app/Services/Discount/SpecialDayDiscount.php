<?php

namespace App\Services\Discount;

use App\Models\Order;
use App\Models\SpecialDay;

class SpecialDayDiscount extends DiscountHandler
{
    protected function apply(Order $order, float $subtotal, array &$appliedDiscounts): float
    {
        $isSpecialDay = SpecialDay::whereDate('date', $order->created_at->toDateString())->exists();

        if ($isSpecialDay) {
            $discount = $subtotal * 0.20;
            $appliedDiscounts[] = ['name' => 'Special Day', 'amount' => round($discount, 2)];
            return $subtotal - $discount;
        }

        return $subtotal;
    }
}

