<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_prices', function (Blueprint $table) {
            $table->unsignedBigInteger("product_id");
            $table->unsignedInteger("quantity");
            $table->unsignedDecimal("price");

            $table->primary([
                "product_id",
                "quantity",
                "price"
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('special_prices');
    }
}
