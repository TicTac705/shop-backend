<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogBasketsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_baskets_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('basket_id');
            $table->unsignedBigInteger('product_id');
            $table->bigInteger('count');
            $table->double('price');
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('catalog_products')
                ->onDelete('cascade');

            $table->foreign('basket_id')
                ->references('id')
                ->on('catalog_baskets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_baskets_products');
    }
}
