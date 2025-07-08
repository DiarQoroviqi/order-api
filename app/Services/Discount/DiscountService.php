<?php

namespace App\Services\Discount;

use App\Models\Order;

class DiscountService
{
    public function applyDiscounts(Order $order, float $subtotal): array
    {
        $appliedDiscounts = [];

        $chain = new OrderTotalDiscount();
        $chain->setNext(new LoyaltyDiscount())
            ->setNext(new SpecialDayDiscount());

        $total = $chain->handle($order, $subtotal, $appliedDiscounts);

        return [
            'subtotal' => round($subtotal, 2),
            'discounts' => $appliedDiscounts,
            'total' => round($total, 2)
        ];
    }
}
