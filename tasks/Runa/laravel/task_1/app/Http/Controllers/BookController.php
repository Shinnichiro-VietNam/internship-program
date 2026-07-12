<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookCollection;

class BookController extends Controller
{
    // 1. 本の一覧を取得
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('author')) {
            $query->where('author', 'like', '%' . $request->query('author') . '%');
        }
        if ($request->has('min_price')) {
            $query->where('price', '>=', (int)$request->query('min_price'));
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', (int)$request->query('max_price'));
        }

        $query->orderBy('book_id', 'asc');

        if ($request->has('page')) {
            $perPage = min((int)$request->query('per_page', 15), 50);
            $paginatedBooks = $query->simplePaginate($perPage);

            return response()->json([
                'data' => BookResource::collection($paginatedBooks->items()),
                'meta' => [
                    'current_page' => $paginatedBooks->currentPage(),
                    'per_page'     => $paginatedBooks->perPage(),
                    'total'        => count($paginatedBooks->items()),
                    'last_page'    => $paginatedBooks->hasMorePages() ? $paginatedBooks->currentPage() + 1 : $paginatedBooks->currentPage(),
                ]
            ], 200);
        }

        $books = $query->get();
        return new \App\Http\Resources\BookCollection($books);
    }

    // 2. 本の詳細を取得
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return new BookResource($book);
    }

    // 3. 新しい本を登録
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        $book = new Book();
        $book->title = $validated['title'];
        $book->author= $validated['author'];
        $book->price = $validated['price'] ?? 0;
        $book->stock_qty = $validated['stock_qty'] ?? 0;
        $book->save();

        return (new BookResource($book))
            ->response()
            ->setStatusCode(201)
            ->header('Location', '/api/books/' . $book->book_id);
    }

    // 4. 本の情報を更新
    public function update(UpdateBookRequest $request, $id)
    {
        $validated = $request->validated();

        $book = Book::findOrFail($id);
        $book->fill($validated);
        $book->save();

        return new BookResource($book);
    }

    // 5. 本を削除
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->noContent();
    }

    // 6. 本の販売履歴を取得
    public function orderItems($bookId)
    {
        $book = Book::find($bookId);
        if (!$book) {
            return response()->json([
                'error' => [
                    'code'    => 'NOT_FOUND',
                    'message' => 'Book not found.'
                ]
            ], 404);
        }

        $orderItems = $book->orderItems()->with('order')->get();

        $formattedItems = [];
        foreach ($orderItems as $item) {
            $formattedItems[] = [
                'order_id' => $item->order_id,
                'quantity' => $item->quantity,
                'unit_price' => (int)$item->unit_price,
                'order_date' => $item->order ? $item->order->order_date : null,
                'status'=> $item->order ? $item->order->status : null,
            ];
        }

        return response()->json($formattedItems, 200);
    }
}