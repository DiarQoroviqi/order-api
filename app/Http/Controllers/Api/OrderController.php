<?php

namespace App\Http\Controllers\Api;

use App\Actions\FormatOrder;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\Discount\DiscountService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = Order::create([
            'customer_id' => $request->validated()['customer_id'],
            'status' => OrderStatus::PENDING->value,
        ]);

        return response()->json([
            'message' => 'Order created successfully.',
            'order' => new OrderResource($order),
        ], Response::HTTP_CREATED);
    }

    public function show(Order $order, FormatOrder $action): JsonResponse
    {
        return response()->json(
            $action->handle($order),
            Response::HTTP_OK
        );
    }
}
