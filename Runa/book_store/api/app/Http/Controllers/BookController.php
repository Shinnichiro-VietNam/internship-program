<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Queries\Book\ListBooksQuery;
use App\Http\Resources\Book\BookResource;
use App\Http\Responses\ResponseData;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;
use App\Queries\Book\FindBookQuery;


class BookController extends Controller
{
    public function index(Request $request, ListBooksQuery $query): ResponseData
    {
        $this->authorize('viewAny', Book::class);

        $books = $query->paginate($request);

        return $this->httpOk(
            (new PaginationResource($books, BookResource::class))->resolve()
        );
    }

    public function show(int $book, FindBookQuery $query): ResponseData
    {
        $found = $query->handle($book);

        if ($found === null) {
            abort(404);
        }

        $this->authorize('view', $found);

        return $this->httpOk(new BookResource($found));
    }
}