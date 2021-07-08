<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CheckoutController extends Controller
{
    /**
     * Action that handles checkout. It is listening on /api/checkout route for post requests.
     *
     * @param CheckoutRequest $request
     *
     * @return JsonResponse
     */
    public function checkout(CheckoutRequest $request): JsonResponse
    {
        /** @var Order $order */
        $order = $request->order ?
            Order::with("orderItems.product")->find($request->order) :
            Order::with("orderItems.product")->create();

        /** @var Product $product */
        $product = Product::find($request->product);

        $quantity = $request->quantity;

        $product->orderItems()->create([
            "quantity" => $quantity,
            "order_id" => $order->id
        ]);

        return response()->json(new OrderResource($order->fresh()));
    }
}
