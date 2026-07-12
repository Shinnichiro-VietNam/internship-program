<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->order_id,
            'order_date' => $this->order_date,
            'status'     => $this->status,
            'customer'   => $this->customer ? [
                'id'        => $this->customer->customer_id,
                'full_name' => $this->customer->full_name,
                'city'      => $this->customer->city,
            ] : null,
            'items'      => $this->relationLoaded('orderItems')
                            ? OrderItemResource::collection($this->orderItems)
                            : null,
        ];
    }
}