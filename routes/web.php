<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// 後臺管理
Route::prefix('admin')->group(function () {
    // Menu 管理 頁
    Route::name('MenusPage')->get('menus', ['App\Http\Controllers\MenuController'::class, 'MenusPage']);
    // 新增 Menu 頁
    Route::name('MenusAddPage')->get('menus/add', ['App\Http\Controllers\MenuController'::class, 'MenusAddPage']);
    // 新增 Menu
    Route::name('MenusAdd')->post('menus/add', ['App\Http\Controllers\MenuController'::class, 'MenusAdd']);
    // 修改 Menu 頁
    Route::name('MenusEditPage')->get('menus/edit/{menus_id}', ['App\Http\Controllers\MenuController'::class, 'MenusEditPage']);
    // 修改 Menu
    Route::name('MenusEdit')->put('menus/edit/{menus_id}', ['App\Http\Controllers\MenuController'::class, 'MenusEdit']);
    // 刪除 Menu
    Route::name('MenusDelete')->delete('menus/delete/{menus_id}', ['App\Http\Controllers\MenuController'::class, 'MenusDelete']);
});
