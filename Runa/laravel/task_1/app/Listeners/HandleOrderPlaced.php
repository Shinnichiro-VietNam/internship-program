<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Jobs\WarnLowStock;
use Illuminate\Support\Facades\Log;

class HandleOrderPlaced
{
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;
        $order->loadMissing('orderItems');

        Log::info('order.placed', ['order_id' => $order->order_id]);

        foreach ($order->orderItems as $item) {
            WarnLowStock::dispatch($item->book_id);
        }
    }
}
