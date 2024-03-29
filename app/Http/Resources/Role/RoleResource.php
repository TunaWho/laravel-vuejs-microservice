<?php

namespace App\Http\Resources\Role;

use App\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request  $request Base request.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'permissions' => $this->permissions,
            'created_at'  => DateHelper::getTimestamp($this->created_at),
        ];
    }
}
