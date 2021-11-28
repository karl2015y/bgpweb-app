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
            
            // 所屬訂單id
            $table->foreignId('order_id')->references('id')->on('orders');
            // 商品id
            $table->string('product_item_id')->nullable();
            // 商品名稱
            $table->string('product_item_name')->nullable();
            // 商品價格
            $table->string('product_item_price')->nullable();
            // 購買數量
            $table->integer('count')->default(0);

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
        Schema::dropIfExists('order_items');
    }
}
