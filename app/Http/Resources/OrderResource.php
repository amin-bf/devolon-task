<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Order $order */
        $order = $this;

        return [
            "id" => $order->id,
            "total" => $order->total,
            "created_at" => $order->created_at,
            "updated_at" => $order->updated_at,
            "items" => OrderItemResource::collection($order->orderItems)
        ];
    }
}
