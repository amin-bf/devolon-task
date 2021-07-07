<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\OrderItem $orderItem */
        $orderItem = $this;
        return [
            "id" => $orderItem->id,
            "quantity" => $orderItem->quantity,
            "amount" => $orderItem->amount,
            "product_name" => $orderItem->product->name,
            "unit_cost" => $orderItem->product->price,
            "product_id" => $orderItem->product->id
        ];
    }
}
