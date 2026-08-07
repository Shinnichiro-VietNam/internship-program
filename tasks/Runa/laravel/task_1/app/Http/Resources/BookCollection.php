<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($book) {
            return [
                'id'     => $book->book_id,
                'title'  => $book->title,
                'author' => $book->author,
                'price'  => (int)$book->price,
            ];
        })->all();
    }
}