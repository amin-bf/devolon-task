<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_a_route_listening_for_post_requests()
    {
        $response = $this->json('post', "/api/checkout");

        $statusCode = $response->getStatusCode();

        $this->assertTrue($statusCode !== 404);
    }

    public function test_responds_with_422_provided_no_product_id()
    {
        $response = $this->json('post', "/api/checkout");

        $response->assertStatus(422)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has("errors.product")
                    ->etc()
            );
    }


    public function test_responds_with_422_provided_invalid_product_id()
    {
        $response = $this->json('post', "/api/checkout", ["product" => "invalid product id"]);

        $response->assertStatus(422)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has("errors.product")
                    ->etc()
            );
    }

    public function test_responds_with_422_provided_non_existent_product_id()
    {
        $response = $this->json('post', "/api/checkout", ["product" => 110]);

        $response->assertStatus(422)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has("errors.product")
                    ->etc()
            );
    }

    public function test_responds_with_422_provided_no_quantity()
    {
        $response = $this->json('post', "/api/checkout");

        $response->assertStatus(422)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has("errors.quantity")
                    ->etc()
            );
    }


    public function test_responds_with_422_provided_invalid_quantity()
    {
        $response = $this->json('post', "/api/checkout", ["quantity" => "invalid quantity"]);

        $response->assertStatus(422)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has("errors.quantity")
                    ->etc()
            );
    }

    public function test_responds_with_422_provided_out_of_range_quantity()
    {
        $response = $this->json('post', "/api/checkout", ["quantity" => -5]);

        $response->assertStatus(422)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has("errors.quantity")
                    ->etc()
            );
    }

    public function test_responds_with_422_provided_non_existent_order_id()
    {
        $response = $this->json('post', "/api/checkout", ["order" => 158]);

        $response->assertStatus(422)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has("errors.order")
                    ->etc()
            );
    }

    public function test_responds_with_200_provided_valid_request_body()
    {
        $response = $this->json('post', "/api/checkout", ["product" => 5, "quantity" => 8]);

        $response->assertStatus(200);
    }

    public function test_responds_with_a_new_order_provided_no_order_id()
    {
        $response = $this->json('post', "/api/checkout", ["product" => 5, "quantity" => 8]);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('id')
                    ->has("total")
                    ->has("items", 1)
                    ->etc()
            );
    }

    public function test_responds_with_the_existing_order_provided_order_id()
    {
        $order = Order::factory()->create();

        $product = Product::find(2);
        $product->orderItems()->create([
            "quantity" => 2,
            "order_id" => $order->id
        ]);

        $product = Product::find(5);
        $product->orderItems()->create([
            "quantity" => 2,
            "order_id" => $order->id
        ]);

        $response = $this->json('post', "/api/checkout", ["product" => 5, "quantity" => 3, "order" => $order->id]);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('id', $order->id)
                    ->has("total")
                    ->has("items", 2)
                    ->where("items.1.product_name", $product->name)
                    ->etc()
            );
    }
}
