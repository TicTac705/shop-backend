<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogProductsImagesTable extends Migration
{
    private string $table = 'catalog_products_images';

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
                $table->unsignedBigInteger('product_id');
                $table->foreign('product_id')->references('id')->on('catalog_products')->onDelete('cascade');
                $table->unsignedBigInteger('image_id');
                $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
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
