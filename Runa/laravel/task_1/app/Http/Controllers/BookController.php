<?php

namespace App\Http\Controllers;

use App\Actions\Book\CreateBook;
use App\Actions\Book\DeleteBook;
use App\Actions\Book\ListBookOrderItems;
use App\Actions\Book\ListBooks;
use App\Actions\Book\ShowBook;
use App\Actions\Book\UpdateBook;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\OrderItemResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // 1. 本の一覧を取得
    public function index(Request $request, ListBooks $listBooks)
    {
        $this->authorize('viewAny', Book::class);

        $books = $listBooks->handle($request->query());

        return $this->httpOk(BookResource::collection($books));
    }

    // 2. 本の詳細を取得
    public function show(Book $book, ShowBook $showBook)
    {
        $this->authorize('view', $book);

        return $this->httpOk(new BookResource($showBook->handle($book)));
    }

    // 3. 新しい本を登録
    public function store(StoreBookRequest $request, CreateBook $createBook)
    {
        $this->authorize('create', Book::class);

        $book = $createBook->handle($request->validated());

        return $this->httpCreated(new BookResource($book))
            ->toResponse($request)
            ->header('Location', route('books.show', $book));
    }

    // 4. 本の情報を更新
    public function update(UpdateBookRequest $request, Book $book, UpdateBook $updateBook)
    {
        $this->authorize('update', $book);

        $book = $updateBook->handle($book, $request->validated());

        return $this->httpOk(new BookResource($book));
    }

    // 5. 本を削除
    public function destroy(Book $book, DeleteBook $deleteBook)
    {
        $this->authorize('delete', $book);

        $deleteBook->handle($book);

        return $this->httpNoContent();
    }

    // 6. 本の販売履歴を取得
    public function orderItems(Book $book, ListBookOrderItems $listBookOrderItems)
    {
        $this->authorize('view', $book);

        $orderItems = $listBookOrderItems->handle($book);

        return $this->httpOk(OrderItemResource::collection($orderItems));
    }
}
