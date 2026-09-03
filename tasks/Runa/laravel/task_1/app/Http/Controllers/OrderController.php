<?php

namespace App\Http\Controllers;

use App\Actions\Order\CreateOrder;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    // 1 注文の一覧を取得
    public function index()
    {
        $this->authorize('viewAny', Order::class);

        $orders = Order::with('customer')->orderBy('order_id', 'desc')->get();

        return $this->httpOk(OrderResource::collection($orders));
    }

    // 2注文の詳細を取得
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['customer', 'orderItems.book']);

        return $this->httpOk(new OrderResource($order));
    }

    // 3 注文を作成
    public function store(StoreOrderRequest $request, CreateOrder $createOrder)
    {
        $this->authorize('create', Order::class);

        $order = $createOrder->handle($request->validated());

        return $this->httpCreated(new OrderResource($order))
            ->toResponse($request)
            ->header('Location', route('orders.show', $order));
    }
}
