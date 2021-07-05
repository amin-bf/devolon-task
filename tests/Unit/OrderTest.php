<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * Has total attribute.
     *
     * @return void
     */
    public function test_has_total_attribute()
    {
        $order = Order::factory()->make();

        $this->assertTrue(is_numeric($order->total));
    }

    /**
     * Has order items relation.
     *
     * @return void
     */
    public function test_has_order_items_relation()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();

        $product->orderItems()->create([
            "quantity" => 2,
            "amount" => 2 * $product->price,
            "order_id" => $order->id
        ]);

        $this->assertTrue(!!$order->orderItems->count());
    }
}
