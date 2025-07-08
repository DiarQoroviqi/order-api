<?php

namespace App\Http\Controllers\Api;

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

    public function show(Order $order, DiscountService $discountService): JsonResponse
    {
        $order->load('products');

        $subtotal = $order->products->sum(function ($product) {
            return $product->pivot->quantity * $product->price;
        });

        $discounted = $discountService->applyDiscounts($order, $subtotal);

        return response()->json([
            'order_id' => $order->id,
            'products' => $order->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->pivot->quantity,
                    'total' => $product->pivot->quantity * $product->price,
                ];
            }),
            ...$discounted
        ]);
    }
}
