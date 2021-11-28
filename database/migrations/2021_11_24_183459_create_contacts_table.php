<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->string('name'); //聯絡人姓名
            $table->string('email'); //聯絡人信箱
            $table->string('message'); //聯絡人訊息
            $table->string('status')->default('未處理'); //聯絡單狀態
            $table->string('note')->nullable();; //聯絡單備註(廠商自己看)


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
        Schema::dropIfExists('contacts');
    }
}
