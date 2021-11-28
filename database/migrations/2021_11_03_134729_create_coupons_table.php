<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            // 優惠券名稱
            $table->string('title');
            // 優惠券說明
            $table->text('description')->nullable();
            // 優惠券代碼
            $table->string('code');
            // 優惠券類型 折扣或打折
            $table->string('type')->default('discount');
            // 優惠券的數字
            $table->float('number')->default(0);
            // 優惠券一定要買什麼商品才能使用
            $table->foreignId('product_id')->nullable();
            // 優惠券一定要超過多少錢才能使用
            $table->integer('minimum_price')->default(0);
            // 優惠券一個人可以用幾次
            $table->boolean('use_times')->default(1);
            //優惠券開始時間
            $table->timestamp('start_at');
            //優惠券結束時間
            $table->timestamp('end_at');

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
        Schema::dropIfExists('coupons');
    }
}
