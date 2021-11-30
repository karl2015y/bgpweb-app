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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::name('HomePage')->get('/', ['App\Http\Controllers\HomePageController'::class, 'HomePage']);


// 商城管理
Route::prefix('shop')->group(function () {
    // 商城首頁
    Route::name('ShopIndexPage')->get('/', ['App\Http\Controllers\ShopController'::class, 'ShopIndexPage']);
    // 商城分類
    Route::name('categorysPage')->get('/categorys', ['App\Http\Controllers\ShopController'::class, 'categorysPage']);
    // 商城多商品頁
    Route::name('productsPage')->get('/products', ['App\Http\Controllers\ShopController'::class, 'productsPage']);
    // 商城商品單頁
    Route::name('productPage')->get('/product/{id}', ['App\Http\Controllers\ShopController'::class, 'productPage']);
    // 將商品加到購物車
    Route::name('addProductItemToOrder')->get('/addToCart', ['App\Http\Controllers\CartController'::class, 'addProductItemToOrder']);
    // 將商品從購物車中移除
    Route::name('removeProductItemFromOrder')->get('/removeFromCart', ['App\Http\Controllers\CartController'::class, 'removeProductItemFromOrder']);
    // 增加購物車中商品的數量
    Route::name('addProductItemCountFromOrder')->get('/addItemCountFromCart', ['App\Http\Controllers\CartController'::class, 'addProductItemCountFromOrder']);
    // 減少購物車中商品的數量
    Route::name('lessProductItemCountFromOrder')->get('/lessItemCountFromCart', ['App\Http\Controllers\CartController'::class, 'lessProductItemCountFromOrder']);

    // 商城結帳
    Route::name('checkoutPage')->get('/checkout', ['App\Http\Controllers\OrderController'::class, 'checkoutPage']);
    // 使用優惠券
    Route::name('useCoupon')->post('/useCoupon', ['App\Http\Controllers\OrderController'::class, 'useCoupon']);
    // 取消優惠券
    Route::name('userCancelCoupon')->get('/userCancelCoupon', ['App\Http\Controllers\OrderController'::class, 'userCancelCoupon']);


    //選擇物流
    Route::name('shippingSelectionPage')->get('/shippingSelectionPage', ['App\Http\Controllers\OrderController'::class, 'shippingSelectionPage']);
    Route::name('shippingSelection')->post('/shippingSelection', ['App\Http\Controllers\OrderController'::class, 'shippingSelection']);

    //選擇綠界物流
    Route::name('LogisticsSelection')->get('/LogisticsSelection', ['App\Http\Controllers\ECPayLogisticsController'::class, 'LogisticsSelection']);
    // 取得使用者選擇的物流方式
    Route::name('GetUserChooseLogistcs')->post('/GetUserChooseLogistcs', ['App\Http\Controllers\ECPayLogisticsController'::class, 'GetUserChooseLogistcs']);

    //確認並準備付款
    Route::name('checkAndPayPage')->get('/checkAndPayPage', ['App\Http\Controllers\OrderController'::class, 'checkAndPayPage']);
    
    // 付款
    Route::name('payPage')->post('/payPage', ['App\Http\Controllers\OrderController'::class, 'payPage']);
    //綠界付完款轉址路由方法
    Route::name('checkoutCallback')->post('/checkoutCallback', ['App\Http\Controllers\ECPayPaymentController'::class, 'checkoutCallback']);
    // 綠界金流server Callback
    Route::name('checkoutServerCallback')->post('/checkoutServerCallback', ['App\Http\Controllers\ECPayPaymentController'::class, 'checkoutServerCallback']);

    

    // 處理過期訂單
    Route::name('makeDelayOrderCountBack2Product')->get('/makeDelayOrderCountBack2Product', ['App\Http\Controllers\OrderController'::class, 'makeDelayOrderCountBack2Product']);
});


// 會員中心
Route::prefix('member')->group(function () {
    // 登入(查詢訂單首頁)
    Route::name('loginPage')->get('/loginPage', ['App\Http\Controllers\MemberCenterController'::class, 'loginPage']);
    Route::name('login')->post('/login', ['App\Http\Controllers\MemberCenterController'::class, 'login']);
    // 註冊
    Route::name('registerPage')->get('/registerPage', ['App\Http\Controllers\MemberCenterController'::class, 'registerPage']);
    Route::name('register')->post('/register', ['App\Http\Controllers\MemberCenterController'::class, 'register']);

    // 訂單資訊
    Route::name('myOrderPage')->get('/myOrderPage', ['App\Http\Controllers\MemberCenterController'::class, 'myOrderPage']);
    // 重新付款
    Route::name('payAgain')->post('/payAgain/{order_id}', ['App\Http\Controllers\MemberCenterController'::class, 'payAgain']);
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
    //---------------------------------------
    // 頁面管理
    // 頁面列表頁
    Route::name('PagesPage')->get('pages', ['App\Http\Controllers\PageController'::class, 'PagesPage']);
    // 新增頁面頁
    Route::name('PagesAddPage')->get('pages/add', ['App\Http\Controllers\PageController'::class, 'PagesAddPage']);
    // 新增頁面
    Route::name('PagesAdd')->post('pages/add', ['App\Http\Controllers\PageController'::class, 'PagesAdd']);
    // 修改頁面頁
    Route::name('PagesEditPage')->get('pages/edit/{pages_id}', ['App\Http\Controllers\PageController'::class, 'PagesEditPage']);
    // 修改頁面
    Route::name('PagesEdit')->put('pages/edit/{pages_id}', ['App\Http\Controllers\PageController'::class, 'PagesEdit']);
    // 刪除頁面
    Route::name('PagesDelete')->delete('pages/delete/{pages_id}', ['App\Http\Controllers\PageController'::class, 'PagesDelete']);

    // 頁面元件列表頁
    Route::name('PageComponentsPage')->get('pages/{pages_id}', ['App\Http\Controllers\PageComponentsController'::class, 'PageComponentsPage']);
    // 新增頁面元件頁
    Route::name('PageComponentsAddPage')->get('pages/{pages_id}/add', ['App\Http\Controllers\PageComponentsController'::class, 'PageComponentsAddPage']);
    // 新增頁面元件
    Route::name('PageComponentsAdd')->post('pages/{pages_id}/add', ['App\Http\Controllers\PageComponentsController'::class, 'PageComponentsAdd']);
    // 修改頁面元件 index
    Route::name('PageComponentsAdjustIndex')->put('pages/{pages_id}/index/{page_components_id}', ['App\Http\Controllers\PageComponentsController'::class, 'PageComponentsAdjustIndex']);
    // 修改頁面元件頁
    Route::name('PageComponentsEditPage')->get('pages/{pages_id}/edit/{page_components_id}', ['App\Http\Controllers\PageComponentsController'::class, 'PageComponentsEditPage']);
    // 修改頁面元件
    Route::name('PageComponentsEdit')->put('pages/{pages_id}/edit/{page_components_id}', ['App\Http\Controllers\PageComponentsController'::class, 'PageComponentsEdit']);
    // 刪除頁面元件
    Route::name('PageComponentsDelete')->delete('pages/{pages_id}/delete/{page_components_id}', ['App\Http\Controllers\PageComponentsController'::class, 'PageComponentsDelete']);

    //---------------------------------------
    // 訂單管理
    // 訂單列表 - 全部
    Route::name('ordersPage')->get('ordersPage', ['App\Http\Controllers\AdminOrderController'::class, 'ordersPage']);
    // 訂單列表 - 已付款2揀貨中
    Route::name('ordersPaid2PreOutPage')->get('ordersPaid2PreOutPage', ['App\Http\Controllers\AdminOrderController'::class, 'ordersPaid2PreOutPage']);
    // 訂單狀態改為「揀貨中」
    Route::name('ordersPaid2PreOut')->post('ordersPaid2PreOut', ['App\Http\Controllers\AdminOrderController'::class, 'ordersPaid2PreOut']);
    // 訂單列表 - 揀貨中2已出貨
    Route::name('ordersPreOut2OutPage')->get('ordersPreOut2OutPage', ['App\Http\Controllers\AdminOrderController'::class, 'ordersPreOut2OutPage']);

    // 訂單狀態改為「已出貨」
    Route::name('orderSinglePreOut2OutPage')->get('orderSinglePreOut2OutPage', ['App\Http\Controllers\AdminOrderController'::class, 'orderSinglePreOut2OutPage']);
    Route::name('orderSinglePreOut2Out')->post('orderSinglePreOut2OutPage', ['App\Http\Controllers\AdminOrderController'::class, 'orderSinglePreOut2Out']);

    // 列印出貨單
    Route::name('printOrderShippingData')->post('printOrderShippingData', ['App\Http\Controllers\AdminOrderController'::class, 'printOrderShippingData']);



    //---------------------------------------
    // 聯絡管理
    Route::resource('contact', 'App\Http\Controllers\ContactController');

    // 會員管理
    Route::name('admin_member.index')->get('admin_member', ['App\Http\Controllers\AdminMemberController'::class, 'index']);

     // 系統設定
     Route::name('admin_setting.CFD')->get('admin_setting/CFD', ['App\Http\Controllers\SettingController'::class, 'createFackData']);
     Route::name('admin_setting.index')->get('admin_setting', ['App\Http\Controllers\SettingController'::class, 'index']);
     Route::name('admin_setting.edit')->get('admin_setting/{id}/{type}', ['App\Http\Controllers\SettingController'::class, 'edit']);
     Route::name('admin_setting.update')->put('admin_setting/{id}', ['App\Http\Controllers\SettingController'::class, 'update']);
     Route::name('admin_setting.update_pic')->put('admin_setting/{id}/pic', ['App\Http\Controllers\SettingController'::class, 'update_pic']);

    //---------------------------------------
    // 優惠券管理
    Route::resource('coupon', 'App\Http\Controllers\AdminCouponController');

    //---------------------------------------
    // 商品類別管理
    Route::resource('admin_product_category', 'App\Http\Controllers\AdminProductCategoryController');
    // 商品管理
    Route::resource('admin_product', 'App\Http\Controllers\AdminProductController');
    // 商品圖片管理
    Route::resource('admin_product_imgs', 'App\Http\Controllers\AdminProductImagesController');
    // 商品品項管理
    Route::name('admin_product_item.edit')->get('admin_product_item/edit/{id}', ['App\Http\Controllers\AdminProductItemController'::class, 'edit']);
    Route::name('admin_product_item.update')->put('admin_product_item/edit/{id}', ['App\Http\Controllers\AdminProductItemController'::class, 'update']);
    Route::name('admin_product_item.editPic')->get('admin_product_item/edit_pic/{id}', ['App\Http\Controllers\AdminProductItemController'::class, 'editPic']);
    Route::name('admin_product_item.updatePic')->put('admin_product_item/edit_pic/{id}', ['App\Http\Controllers\AdminProductItemController'::class, 'updatePic']);
    
     // 更新商品品項
     Route::name('admin_product_type.UpdateItems')->get('admin_product_type/UpdateItems', ['App\Http\Controllers\AdminProductTypeController'::class, 'UpdateItems']);


    // 商品規格
    Route::name('admin_product_type.TypeListPage')->get('admin_product_type/TypeListPage', ['App\Http\Controllers\AdminProductTypeController'::class, 'TypeListPage']);
    Route::name('admin_product_type.CreateTypePage')->get('admin_product_type/CreateTypePage', ['App\Http\Controllers\AdminProductTypeController'::class, 'CreateTypePage']);
    Route::name('admin_product_type.CreateType')->post('admin_product_type/CreateType', ['App\Http\Controllers\AdminProductTypeController'::class, 'CreateType']);
    Route::name('admin_product_type.EditTypePage')->get('admin_product_type/EditTypePage/{id}', ['App\Http\Controllers\AdminProductTypeController'::class, 'EditTypePage']);
    Route::name('admin_product_type.EditType')->put('admin_product_type/EditType/{id}', ['App\Http\Controllers\AdminProductTypeController'::class, 'EditType']);
    Route::name('admin_product_type.DeleteType')->delete('admin_product_type/DeleteType/{id}', ['App\Http\Controllers\AdminProductTypeController'::class, 'DeleteType']);
   

    // CropController
    Route::prefix('pics')->group(function () {
        Route::get('/',  ['App\Http\Controllers\CropController'::class, 'home'])->name('picuploadPage');
        Route::post('upload',  ['App\Http\Controllers\CropController'::class, 'postUpload'])->name('picupload');
        Route::post('/wangeditor_upload',  ['App\Http\Controllers\CropController'::class, 'wangeditorUpload'])->name('upload-img');
        Route::post('crop',  ['App\Http\Controllers\CropController'::class, 'postCrop'])->name('piccrop');
    });
});

// 顯示畫面
Route::name('PagesPageView')->get('{url}', ['App\Http\Controllers\PageController'::class, 'PagesPageView']);
