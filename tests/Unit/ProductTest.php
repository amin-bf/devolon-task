<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{

    /**
     * Has price attribute.
     *
     * @return void
     */
    public function test_has_price_attribute()
    {
        $product = Product::factory()->make();

        $this->assertTrue(!!$product->price);
    }

    /**
     * Has name attribute.
     *
     * @return void
     */
    public function test_has_name_attribute()
    {
        $product = Product::factory()->make();

        $this->assertTrue(!!$product->name);
    }

    /**
     * Has special prices relation.
     *
     * @return void
     */
    public function test_has_special_prices_relation()
    {
        $product = Product::factory()->create();

        $this->assertTrue(!!$product->specialPrices->count());
    }

    /**
     * Has orderItems relation.
     *
     * @return void
     */
    public function test_has_order_items_relation()
    {
        $product = Product::factory()->create();
        $order = Order::create([
            "total" => 2 * $product->price
        ]);

        $orderItem = $product->orderItems()->create([
            "quantity" => 2,
            "order_id" => $order->id
        ]);

        $this->assertTrue(!!$product->orderItems->count());
        $this->assertTrue($product->orderItems->first()->quantity === $orderItem->quantity);
    }
}
