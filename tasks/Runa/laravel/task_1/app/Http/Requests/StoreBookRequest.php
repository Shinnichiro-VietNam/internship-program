<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;    }

    public function rules(): array
    {
        return [
            'title'     => 'required|string',
            'author'    => 'required|string',
            'price'     => 'required|integer|min:0',
            'stock_qty' => 'required|integer|min:0',
        ];
    }
}