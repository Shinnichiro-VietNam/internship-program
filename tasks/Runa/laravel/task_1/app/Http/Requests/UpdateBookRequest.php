<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('put')) {
            return [
                'title'          => 'required|string',
                'author'         => 'required|string',
                'price'          => 'required|numeric|gt:0',
                'stock_qty'      => 'required|integer|min:0',
                'published_year' => 'nullable|integer',
            ];
        }

        return [
            'title'          => 'sometimes|required|string',
            'author'         => 'sometimes|required|string',
            'price'          => 'sometimes|numeric|gt:0',
            'stock_qty'      => 'sometimes|integer|min:0',
            'published_year' => 'nullable|integer',
        ];
    }

    protected function passedValidation()
    {
        if ($this->isMethod('patch') && empty($this->all())) {
            throw new HttpResponseException(
                response()->json([
                    'error' => [
                        'code' => 'BAD_REQUEST',
                        'message' => 'Empty PATCH body'
                    ]
                ], 400)
            );
        }
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