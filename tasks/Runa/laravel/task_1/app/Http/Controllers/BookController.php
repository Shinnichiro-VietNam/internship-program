<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\OrderItemResource;

class BookController extends Controller
{
    // 1. 本の一覧を取得
    public function index(Request $request)
    {
        $books = Book::query()
            ->when($request->filled('author'), fn ($q) => $q->where('author', 'like', '%' . $request->query('author') . '%'))
            ->when($request->filled('min_price'), fn ($q) => $q->where('price', '>=', $request->query('min_price')))
            ->when($request->filled('max_price'), fn ($q) => $q->where('price', '<=', $request->query('max_price')))
            ->orderBy('book_id', 'asc');

        if ($request->has('page')) {
            $perPage = min((int) $request->query('per_page', 15), 50);
            return $this->httpOk(BookResource::collection($books->paginate($perPage)));
        }

        return $this->httpOk(BookResource::collection($books->get()));
    }

    // 2. 本の詳細を取得
    public function show(Book $book)
    {
        return $this->httpOk(new BookResource($book));
    }

    // 3. 新しい本を登録
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        return $this->httpCreated(new BookResource($book))
            ->toResponse($request)
            ->header('Location', route('books.show', $book));
    }

    // 4. 本の情報を更新
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return $this->httpOk(new BookResource($book));
    }

    // 5. 本を削除
    public function destroy(Book $book)
    {
        $book->delete();

        return $this->httpNoContent();
    }

    // 6. 本の販売履歴を取得
    public function orderItems(Book $book)
    {
        $book->load('orderItems.order');

        return $this->httpOk(OrderItemResource::collection($book->orderItems));
    }
}