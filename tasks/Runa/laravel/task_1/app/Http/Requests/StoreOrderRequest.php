<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id'      => 'required|integer|exists:customers,customer_id',
            'items'            => 'required|array|min:1',
            'items.*.book_id'  => 'required|integer|exists:books,book_id|distinct',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
