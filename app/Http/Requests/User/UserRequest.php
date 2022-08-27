<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['email'],
            'password' => ['required'],
        ];
    }
}
