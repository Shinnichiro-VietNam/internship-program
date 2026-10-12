<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'          => 'required',
            'author'         => 'required',
            'price'          => 'sometimes|numeric|gt:0',
            'stock_qty'      => 'sometimes|integer|min:0',
            'published_year' => 'nullable|integer',
        ];
    }
}
