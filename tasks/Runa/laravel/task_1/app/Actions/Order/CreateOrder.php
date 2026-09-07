<?php

namespace App\Actions\Order;

use App\Events\OrderPlaced;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class CreateOrder
{
    public function handle(array $data): Order
    {
        $order = DB::transaction(function () use ($data) {
            $order = Order::create([
                'customer_id' => $data['customer_id'],
                'order_date'  => now()->toDateString(),
                'status'      => 'pending',
            ]);

            foreach ($data['items'] as $item) {
                $book = Book::where('book_id', $item['book_id'])->lockForUpdate()->firstOrFail();

                if ($book->stock_qty < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => 'Insufficient stock for book '.$book->book_id,
                    ]);
                }

                $book->decrement('stock_qty', $item['quantity']);

                OrderItem::create([
                    'order_id'   => $order->order_id,
                    'book_id'    => $book->book_id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $book->price,
                ]);
            }

            return $order->load(['customer', 'orderItems.book']);
        });

        OrderPlaced::dispatch($order);

        return $order;
    }
}
