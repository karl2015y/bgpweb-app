<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('pay_type', 100)->nullable(); //付款類型
            $table->string('trade_no', 100)->nullable(); //金流序號
            $table->timestamp('pay_at')->nullable(); //付款時間
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('pay_type');
            $table->dropColumn('trade_no');
            $table->dropColumn('pay_at');
        });
    }
}
