<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("product_id");
            $table->integer("quantity")->default(1);
            $table->integer("amount")->default(0);

            // Create constraint to product id
            $table->foreign("product_id")
                ->references("id")
                ->on("products")
                ->onDelete("cascade")
                ->onUpdate("cascade");

            // Create constraint to order id
            $table->foreign("order_id")
                ->references("id")
                ->on("orders")
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
