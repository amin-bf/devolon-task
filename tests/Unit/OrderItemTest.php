<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Has quantity attribute.
     *
     * @return void
     */
    public function test_has_quantity_attribute()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();

        $orderItem = $product->orderItems()->create([
            "quantity" => 2,
            "amount" => 2 * $product->price,
            "order_id" => $order->id
        ]);

        $this->assertTrue(is_numeric($orderItem->quantity));
    }

    /**
     * Has amount attribute.
     *
     * @return void
     */
    public function test_has_amount_attribute()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();

        $orderItem = $product->orderItems()->create([
            "quantity" => 2,
            "amount" => 2 * $product->price,
            "order_id" => $order->id
        ]);

        $this->assertTrue(is_numeric($orderItem->amount));
    }

    /**
     * Has order relation.
     *
     * @return void
     */
    public function test_has_order_relation()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();

        $orderItem = $product->orderItems()->create([
            "quantity" => 2,
            "amount" => 2 * $product->price,
            "order_id" => $order->id
        ]);

        $this->assertTrue(!!$orderItem->order);
    }

    /**
     * Has product relation.
     *
     * @return void
     */
    public function test_has_product_relation()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();

        $orderItem = $product->orderItems()->create([
            "quantity" => 2,
            "amount" => 2 * $product->price,
            "order_id" => $order->id
        ]);

        $this->assertTrue(!!$orderItem->product);
    }
}
