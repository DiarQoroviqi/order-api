<?php

namespace App\Http\Controllers\Api;

use App\Actions\UpdateOrderStatus;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderStatusController extends Controller
{
    public function __invoke(
        UpdateOrderStatusRequest $request,
        Order $order,
        UpdateOrderStatus $action
    ): JsonResponse {
        $validated = $request->validated();
        $action->handle($order, OrderStatus::from($validated['status']));

        return response()->json([
            'message' => 'Order status updated successfully.',
            'status' => $order->status,
        ], Response::HTTP_OK);
    }
}
