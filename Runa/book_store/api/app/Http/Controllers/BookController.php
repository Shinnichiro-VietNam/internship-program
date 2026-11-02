<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Queries\Book\ListBooksQuery;
use App\Http\Resources\Book\BookResource;
use App\Http\Responses\ResponseData;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;

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
}