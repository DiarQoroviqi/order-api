<?php

namespace App\Services\Discount;

use App\Models\Order;

abstract class DiscountHandler
{
    protected ?DiscountHandler $next = null;

    public function setNext(DiscountHandler $handler): DiscountHandler
    {
        $this->next = $handler;
        return $handler;
    }

    public function handle(Order $order, float $runningTotal, array &$appliedDiscounts): float
    {
        $discounted = $this->apply($order, $runningTotal, $appliedDiscounts);

        return $this->next
            ? $this->next->handle($order, $discounted, $appliedDiscounts)
            : $discounted;
    }

    abstract protected function apply(Order $order, float $subtotal, array &$appliedDiscounts): float;
}
