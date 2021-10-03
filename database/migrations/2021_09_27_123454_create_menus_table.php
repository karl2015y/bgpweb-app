<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            //上級選單
            $table->foreignId('menu_id')->nullable();
            //選單排序
            $table->string('index');
            //選單連結
            $table->string('link');
            //選單名稱
            $table->string('name');
            //手機顯示
            $table->boolean('show_phone');
            //電腦顯示
            $table->boolean('show_pc');

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
        Schema::dropIfExists('menus');
    }
}
