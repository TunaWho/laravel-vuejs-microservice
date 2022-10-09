<?php

namespace App\Http\Resources\Order;

use App\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'product_title' => $this->product_title,
            'price'         => (float) $this->price,
            'quantity'      => (int) $this->quantity,
            'created_at'    => DateHelper::getTimestamp($this->created_at),
        ];
    }
}
