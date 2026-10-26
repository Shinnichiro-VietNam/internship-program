<?php


namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->book_id,
            'title' => $this->title,
            'author' => $this->author,
            'price' => $this->price,
            'stock_qty' => $this->stock_qty,
            'published_year' => $this->published_year,
        ];
    }
}