<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    // 1 注文の一覧を取得
    public function index()
    {
        $this->authorize('viewAny', Order::class);

        $orders = Order::with('customer')->orderBy('order_id', 'desc')->get();

        return OrderResource::collection($orders);
    }

    // 2注文の詳細を取得
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['customer', 'orderItems.book']);

        return new OrderResource($order);
    }
}
