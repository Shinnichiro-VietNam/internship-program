<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'error' => [
                    'code' => 'BAD_REQUEST',
                    'message' => 'The given data was invalid.'
                ]
            ], 400)
        );
    }
}