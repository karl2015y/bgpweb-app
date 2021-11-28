<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_items', function (Blueprint $table) {
            $table->id();

            // 所屬商品id
            $table->foreignId('product_id')->references('id')->on('products');
            // 商品item名稱
            $table->string('name');
            // 商品item簡介
            $table->text('description')->nullable();
            // 商品item圖片位置
            $table->string('img_url')->nullable();
            //商品item數量
            $table->integer('count')->default(1);
            //商品item原價格
            $table->integer('org_price')->default(0);
            //商品item價格
            $table->integer('sell_price')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_items');
    }
}
