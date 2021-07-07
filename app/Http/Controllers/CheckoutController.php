<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function checkout(CheckoutRequest $request)
    {
        /** @var Order $order */
        $order = $request->order ?
            Order::with("orderItems.product")->find($request->order) :
            Order::with("orderItems.product")->create();
        /** @var Product $product */
        $product = Product::find($request->product);
        /** @var int $quantity */
        $quantity = $request->quantity;

        $product->orderItems()->create([
            "quantity" => $quantity,
            "order_id" => $order->id
        ]);

        return response()->json(new OrderResource($order->fresh()));
    }
}
