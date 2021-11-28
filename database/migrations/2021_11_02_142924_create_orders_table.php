<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // session id
            $table->string('session_id');
            // 訂單狀態
            $table->string('status')->default('preCreate');
            // 收件人姓名
            $table->string('receiver_name')->nullable();
            // 收件人電話
            $table->string('receiver_phone')->nullable();
            // 收件人Email
            $table->string('receiver_email')->nullable();
            // 收件人地址
            $table->string('receiver_address')->nullable();
            // 收件人對訂單備註
            $table->string('receiver_note')->nullable();
            // 物流訂單id
            $table->string('logistics_id')->nullable();
            // 物流類型(全家 7-11店到店)
            $table->string('ship_type')->nullable();
            // 運費
            $table->integer('ship_cost')->default(0);
            // 使用的優惠券代碼
            $table->string('coupon_code')->nullable();
            // 使用的優惠券折抵的費用
            $table->integer('coupon_discount')->default(0);
            // 商品的總價
            $table->integer('all_product_price')->default(0);
            // 訂單整體需要付的總價
            $table->integer('order_pay_price')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
