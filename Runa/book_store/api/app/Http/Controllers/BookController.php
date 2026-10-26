<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Queries\Book\ListBooksQuery;
use App\Http\Resources\Book\BookResource;
use App\Http\Responses\ResponseData;
use Illuminate\Http\Request;


class BookController extends Controller
{
    public function index(Request $request, ListBooksQuery $query): ResponseData
    {
        $this->authorize('viewAny', Book::class);

        $books = $query->paginate($request);

        return $this->httpOk([
            'items' => BookResource::collection($books)->resolve(),
            'current_page' => $books->currentPage(),
            'last_page' => $books->lastPage(),
            'per_page' => $books->perPage(),
            'total' => $books->total(),
        ]);
    }
}