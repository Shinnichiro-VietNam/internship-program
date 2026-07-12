<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    // 1 注文の一覧を取得
    public function index()
    {
        $orders = Order::with('customer')->orderBy('order_id', 'desc')->get();

        return OrderResource::collection($orders);
    }

    // 2注文の詳細を取得
    public function show($orderId)
    {
        $order = Order::with(['customer', 'orderItems.book'])->find($orderId);

        if (!$order) {
            return response()->json([
                'error' => [
                    'code'    => 'NOT_FOUND',
                    'message' => 'Order not found.'
                ]
            ], 404);
        }

        return new OrderResource($order);
    }
}