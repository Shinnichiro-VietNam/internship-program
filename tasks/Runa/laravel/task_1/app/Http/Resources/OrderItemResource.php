<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'book_id'    => $this->book_id,
            'title'      => $this->book ? $this->book->title : 'Unknown',
            'quantity'   => (int)$this->quantity,
            'unit_price' => (int)$this->unit_price,
        ];
    }
}