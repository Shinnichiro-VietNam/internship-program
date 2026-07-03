<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $books = $query->orderBy('book_id', 'asc')->get();

        $formattedBooks = $books->map(function ($book) {
            return [
                'id'     => $book->book_id,
                'title'  => $book->title,
                'author' => $book->author,
                'price'  => (int)$book->price,
            ];
        });

        return response()->json($formattedBooks);
    }

    // 2. 本の詳細（1件だけ）を取得
    public function show(Book $book)
    {
        return response()->json([
            'id'     => $book->book_id,
            'title'  => $book->title,
            'author' => $book->author,
            'price'  => (int)$book->price,
        ]);
    }

    // 3. 新しい本を登録
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|string',
            'author'    => 'required|string',
            'price'     => 'required|integer',
            'stock_qty' => 'required|integer',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'error' => 'BAD_REQUEST',
                'messages' => $validator->errors()
            ], 400);
        }

        $validated = $validator->validated();

        $book = new Book();
        $book->title  = $validated['title'];
        $book->author = $validated['author'];
        $book->price  = $validated['price'];
        $book->save();

        // 登録完了
        return response()->json([
            'id'        => $book->book_id,
            'title'     => $book->title,
            'author'    => $book->author,
            'price'     => (int)$book->price,
        ], 201)
        ->header('Location', '/api/books/' . $book->book_id);
    }

    // 4. 本の情報を更新（
    public function update(Request $request, Book $book)
    {
        if ($request->isMethod('patch')) {
            if (empty($request->all())) {
                return response()->json([
                    'error' => 'BAD_REQUEST',
                    'message' => 'Body cannot be empty for PATCH request.'
                ], 400);
            }
        }

        // PUTかPATCHかで、入力チェックのルールを分ける
        if ($request->isMethod('patch')) {
            $rules = [
                'title'     => 'sometimes|string',
                'author'    => 'sometimes|string',
                'price'     => 'sometimes|integer|min:0',
                'stock_qty' => 'sometimes|integer|min:0',
            ];
        } else {
            $rules = [
                'title'     => 'required|string',
                'author'    => 'required|string',
                'price'     => 'required|integer|min:0',
                'stock_qty' => 'required|integer|min:0',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'BAD_REQUEST',
                'messages' => $validator->errors()
            ], 400);
        }

        $validated = $validator->validated();

        $book->fill($validated);
        $book->save();

        return response()->json([
            'id'        => $book->book_id,
            'title'     => $book->title,
            'author'    => $book->author,
            'price'     => (int)$book->price,
        ]);
    }

    // 5. 本を削除
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->noContent();
    }
}