<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogBasketsProductsTable extends Migration
{
    private string $table = 'catalog_baskets_products';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('basket_id');
                $table->foreign('basket_id')->references('id')->on('catalog_baskets')->onDelete('cascade');
                $table->unsignedBigInteger('product_id');
                $table->foreign('product_id')->references('id')->on('catalog_products')->onDelete('cascade');
                $table->bigInteger('count');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
