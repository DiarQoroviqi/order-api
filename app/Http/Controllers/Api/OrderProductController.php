<?php

namespace App\Http\Controllers\Api;

use App\Actions\AddProductToOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductToOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderProductController extends Controller
{
    public function store(
        AddProductToOrderRequest $request,
        Order $order,
        AddProductToOrder $action
    ): JsonResponse
    {
        $validated = $request->validated();

        $action->handle(
            order: $order,
            productId: $validated['product_id'],
            quantity: $validated['quantity'],
        );

        return response()->json([
            'message' => 'Product successfully added to order.',
        ], Response::HTTP_OK);
    }
}
