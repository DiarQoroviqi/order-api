<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = Customer::create($request->validated());

        return response()->json([
            'message'  => 'Customer created successfully.',
            'customer' => new CustomerResource($customer),
        ], Response::HTTP_CREATED);
    }
}
