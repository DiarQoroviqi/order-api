<?php

namespace App\Http\Controllers\Api;

use App\Actions\ListCustomerOrders;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\Discount\DiscountService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CustomerOrderController extends Controller
{
    public function index(Customer $customer, ListCustomerOrders $action): JsonResponse
    {
        $orderData = $action->handle($customer);

        return response()->json($orderData, Response::HTTP_OK);
    }
}
