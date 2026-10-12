<?php

namespace App\Http\Resources;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin OrderItem
 */
class OrderItemResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'book_id'    => $this->book_id,
            'quantity'   => (int) $this->quantity,
            'unit_price' => (int) $this->unit_price,
            'book'       => $this->whenLoaded('book', fn () => BookResource::make($this->book)),
        ];
    }
}
