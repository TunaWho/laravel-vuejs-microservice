<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\BaseRequest;

class RoleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'        => ['required'],
            'permissions' => [
                'required',
                'array',
            ],
        ];
    }
}
