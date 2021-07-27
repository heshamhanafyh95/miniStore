<?php

namespace App\Http\Controllers;

use App\Http\Requests\order\StoreOrderPostRequest;
use App\Services\order\OrderService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function addOrder(StoreOrderPostRequest $request)
    {
        try {
            $result=$this->orderService->Create($request);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($result, 200);
    }
}
