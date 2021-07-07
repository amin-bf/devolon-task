<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
            "order_id" => $order->id
        ]);

        $this->assertTrue(!!$order->orderItems->count());
    }

    /**
     * Updates order total on saving any orderItem
     *
     * @return void
     */
    public function test_updates_order_total_on_saving_any_orderItem()
    {
        $order = Order::factory()->create();

        $product = Product::factory()->create();
        $product->orderItems()->create([
            "quantity" => 2,
            "order_id" => $order->id
        ]);

        $product = Product::factory()->create();
        $product->orderItems()->create([
            "quantity" => 2,
            "order_id" => $order->id
        ]);

        $this->assertTrue((int)$order->fresh()->total === (int)$order->orderItems->sum("amount"));
    }

    /**
     * Merges duplicate product items
     *
     * @return void
     */
    public function test_merges_duplicate_product_items()
    {
        $order = Order::factory()->create();

        $product = Product::factory()->create();
        $product->orderItems()->create([
            "quantity" => 2,
            "order_id" => $order->id
        ]);

        $product->orderItems()->create([
            "quantity" => 3,
            "order_id" => $order->id
        ]);

        $orderItems = $order->orderItems()->where("product_id", $product->id)->get();

        $this->assertTrue($orderItems->count() === 1);

        $this->assertTrue((int)$orderItems->first()->quantity === 5);
    }
}
