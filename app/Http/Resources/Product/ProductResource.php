<?php

namespace App\Http\Resources\Product;

use App\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title'       => $this->title,
            'description' => $this->description,
            'image'       => $this->image,
            'price'       => $this->price,
            'created_at'  => DateHelper::getTimestamp($this->created_at),
            'updated_at'  => DateHelper::getTimestamp($this->updated_at),
        ];
    }
}
