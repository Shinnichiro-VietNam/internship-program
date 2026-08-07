<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->book_id,
            'title'          => $this->title,
            'author'         => $this->author,
            'price'          => (int)$this->price,
            'stock_qty'      => (int)$this->stock_qty,
            'published_year' => $this->published_year ? (int)$this->published_year : null,
        ];
    }
}