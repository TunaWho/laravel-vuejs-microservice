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
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'first_name' => [
                    'nullable',
                    'max:255',
                ],
                'last_name' => [
                    'nullable',
                    'max:255',
                ],
                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                ],
                'password' => [
                    'nullable',
                    'confirmed',
                    !empty($this->password) ? 'min:8|' : '',
                    'min:8',
                    'max:255',
                ],
            ];
        }//end if

        return [
            'first_name' => [
                'required',
                'max:255',
            ],
            'last_name' => [
                'required',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users',
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'max:255',
            ],
        ];
    }
}
