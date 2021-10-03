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
    // 調整 Menu index
    Route::name('MenusAdjustIndex')->put('menus/index/{menus_id}', ['App\Http\Controllers\MenuController'::class, 'MenusAdjustIndex']);
    //---------------------------------------
    // 元件管理
    // 元件列表頁
    Route::name('ComponentsPage')->get('components', ['App\Http\Controllers\ComponentController'::class, 'ComponentsPage']);
    // 新增元件頁
    Route::name('ComponentsAddPage')->get('components/add', ['App\Http\Controllers\ComponentController'::class, 'ComponentsAddPage']);
    // 新增元件
    Route::name('ComponentsAdd')->post('components/add', ['App\Http\Controllers\ComponentController'::class, 'ComponentsAdd']);
    // 修改元件頁
    Route::name('ComponentsEditPage')->get('components/edit/{components_id}', ['App\Http\Controllers\ComponentController'::class, 'ComponentsEditPage']);
    // 修改元件
    Route::name('ComponentsEdit')->put('components/edit/{components_id}', ['App\Http\Controllers\ComponentController'::class, 'ComponentsEdit']);
    // 刪除元件
    Route::name('ComponentsDelete')->delete('components/delete/{components_id}', ['App\Http\Controllers\ComponentController'::class, 'ComponentsDelete']);
    // 預覽元件頁
    Route::name('ComponentsPreviewPage')->get('components/preview/{components_id}', ['App\Http\Controllers\ComponentController'::class, 'ComponentsPreviewPage']);

    // 新增元件類別頁
    Route::name('ComponentsClassifyAddPage')->get('components/class/add', ['App\Http\Controllers\ComponentsClassifyController'::class, 'ComponentsClassifyAddPage']);
    // 新增元件類別
    Route::name('ComponentsClassifyAdd')->post('components/class/add', ['App\Http\Controllers\ComponentsClassifyController'::class, 'ComponentsClassifyAdd']);
    // 修改元件類別頁
    Route::name('ComponentsClassifyEditPage')->get('components/class/edit/{component_classification_id}', ['App\Http\Controllers\ComponentsClassifyController'::class, 'ComponentsClassifyEditPage']);
    // 修改元件類別
    Route::name('ComponentsClassifyEdit')->put('components/class/edit/{component_classification_id}', ['App\Http\Controllers\ComponentsClassifyController'::class, 'ComponentsClassifyEdit']);
    // 刪除元件類別
    Route::name('ComponentsClassifyDelete')->delete('components/class/delete/{component_classification_id}', ['App\Http\Controllers\ComponentsClassifyController'::class, 'ComponentsClassifyDelete']);
});
