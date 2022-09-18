<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;
use App\Rules\Base64Mime;

class UploadImageRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => [
                'required',
                'string',
                new Base64Mime(['jpg', 'png']),
            ],
        ];
    }
}
