<?php

namespace App\Http\Requests;

use App\Http\Responses\ResponseData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

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
                (new ResponseData(
                    Response::HTTP_BAD_REQUEST,
                    null,
                    'Empty PATCH body',
                    ['code' => 'BAD_REQUEST']
                ))->toResponse($this)
            );
        }
    }
}
