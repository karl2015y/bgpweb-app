<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEcpayToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('note')->nullable(); //賣加備註
            $table->string('ecpay_payment')->nullable(); //綠界付款Json
            $table->string('ecpay_shipping')->nullable(); //綠界物流Json

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
            $table->dropColumn('note');
            $table->dropColumn('ecpay_payment');
            $table->dropColumn('ecpay_shipping');
        });
    }
}
