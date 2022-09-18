<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

class ProductRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'title'       => ['nullable'],
                'description' => ['nullable'],
                'image'       => [
                    'nullable',
                    'string',
                ],
                'price' => [
                    'nullable',
                    'numeric',
                    'min:1000',
                ],
            ];
        }//end if

        return [
            'title'       => ['required'],
            'description' => ['nullable'],
            'image'       => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:1000',
            ],
        ];
    }
}
