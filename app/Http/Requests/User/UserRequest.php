<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

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
                'first_name' => ['nullable'],
                'last_name'  => ['nullable'],
                'email'      => [
                    'nullable',
                    'email',
                ],
                'password' => [
                    'nullable',
                    !empty($this->password) ? 'min:8|' : '',
                    'min:8',
                    'max:255',
                ],
            ];
        }

        return [
            'first_name' => ['required'],
            'last_name'  => ['required'],
            'email'      => [
                'email',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
                'min:8',
                'max:255',
            ],
        ];
    }
}
