<?php

namespace App\Actions;

use App\Enums\OrderStatus;
use App\Models\Order;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateOrderStatus
{
    public function handle(Order $order, OrderStatus $status): void
    {
        if ($status === OrderStatus::COMPLETED && $order->products()->count() === 0) {
            throw new BadRequestHttpException("Cannot complete an order with no products.");
        }

        $order->status = $status;
        $order->save();
    }
}
