<?php

namespace App\Http\Resources\Order;

use App\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'first_name'  => $this->first_name,
            'last_name'   => $this->last_name,
            'email'       => $this->email,
            'total'       => $this->total,
            'order_items' => OrderItemResource::collection($this->orderItems),
            'created_at'  => DateHelper::getTimestamp($this->created_at),
        ];
    }
}
