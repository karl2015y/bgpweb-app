<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{

    function __construct()
    {
        $this->createBasicCart();
        $this->computePrice();
    }

    public function getProductItemCanSellCount($product_item_id)
    {
        $count = 'App\Models\productItem'::find($product_item_id)->count;
        $can_sell_count = $count;
        return $can_sell_count;
    }


    // 建立基本訂單
    public function createBasicCart()
    {
        $session_id = session()->getId();
        $order =  'App\Models\Order'::firstOrCreate([
            'session_id' => $session_id
        ]);
        return $order;
    }
    // 查詢訂單
    public function getCartDatas()
    {
        $session_id = session()->getId();
        $order = 'App\Models\Order'::where('session_id', $session_id)->where('status', 'preCreate')->with('Items')->first();
        if($order){
            return $order;
        }else{
            session()->regenerate();
            redirect()->back();
        }
        
    }
    // 查詢訂單
    public function bindCartDatas($data)
    {
        if (!isset($data['cart_datas'])) {
            $data['cart_datas'] = $this->getCartDatas();
        }
        return $data;
    }
    // 計算價錢
    public function computePrice()
    {
        $session_id = session()->getId();
        $order =  'App\Models\Order'::with('Items')->firstOrCreate([
            'session_id' => $session_id
        ]);
        // 初始化價格
        $order->all_product_price = 0;
        // 計算所有價格
        foreach ($order->Items as $item) {
            $order->all_product_price += ($item->product_item_price * $item->count);
        }
        // 把總價減優惠加運費
        $order->order_pay_price = $order->all_product_price - $order->coupon_discount + $order->ship_cost;
        $order->save();
    }

    // 新增商品至購物車
    public function addProductItemToOrder(Request $request)
    {

        if ($request->input('item_id') == null || $request->input('count') == null) {
            $message_title = "加入購物車失敗";
            $message_type = "error";
            $message = "參數錯誤";
            return redirect()->back()
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
        $product_item_id = $request->input('item_id');
        $count = $request->input('count');

        $order =  $this->createBasicCart();
        $order_item = $order->Items()->firstOrCreate([
            'product_item_id' => $product_item_id
        ]);
        if ($order_item->product_item_name == null || $order_item->product_item_price == null) {
            $order_item->update([
                'product_item_name' => $order_item->Product_Item->Product->name . '的' . $order_item->Product_Item->name,
                'product_item_price' =>  $order_item->Product_Item->sell_price
            ]);
        }
        $productItemCanSellCount = $this->getProductItemCanSellCount($product_item_id);
        if ($order_item->count + $count > $productItemCanSellCount) {
            $order_item->update(['count' => $productItemCanSellCount]);
            $message_title = "加入購物車失敗";
            $message_type = "warning";
            $message = "商品數量不足，目前庫存數量僅剩：" . $productItemCanSellCount.'，已將全部庫存加入購物車，進請見諒';

            return redirect()->back()
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        } else {
            $order_item->update(['count' => +$order_item->count + $count]);
            $message_title = "已加入購物車";
            $message_type = "success";
            $message = $order_item->product_item_name . ' x ' . $count;

            return redirect()->back()
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
    }
    // 刪除商品至購物車
    public function removeProductItemFromOrder(Request $request)
    {
        if ($request->input('order_item_id') == null) {
            $message_title = "刪除失敗";
            $message_type = "error";
            $message = "參數錯誤";

            return redirect()->back()
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
        $order_item = 'App\Models\OrderItem'::find($request->input('order_item_id'));
        $order_item->delete();
        $message_title = "已從購物車中刪除";
        $message_type = "success";
        $message = $order_item->product_item_name;
        return redirect()->back()
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }
    // 增加購物車中商品的數量
    public function addProductItemCountFromOrder(Request $request)
    {
        if ($request->input('order_item_id') == null) {
            $message_title = "增加失敗";
            $message_type = "error";
            $message = "參數錯誤";
            return redirect()->back()
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
        $order_item = 'App\Models\OrderItem'::find($request->input('order_item_id'));
        $productItemCanSellCount = $this->getProductItemCanSellCount($order_item->product_item_id);
        if ($productItemCanSellCount <= 0) {
            $message_title = "增加失敗";
            $message_type = "error";
            $message = "目前庫存中" . $order_item->product_item_name . "存貨不足，故此已將此商品從購物車中移除";
            $order_item->delete();

            return redirect()->back()
                ->with('open_control_div', true)
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
        if ($order_item->count + 1 > $productItemCanSellCount) {
            $message_title = "增加失敗";
            $message_type = "error";
            $message = "目前庫存中" . $order_item->product_item_name . "的數量只剩" . $productItemCanSellCount . '，因此無法新增';

            return redirect()->back()
                ->with('open_control_div', true)
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }


        $order_item->update(['count' => $order_item->count + 1]);
        return redirect()->back()
            ->with('open_control_div', true);
    }
    // 減少購物車中商品的數量
    public function lessProductItemCountFromOrder(Request $request)
    {
        if ($request->input('order_item_id') == null) {
            $message_title = "減少失敗";
            $message_type = "error";
            $message = "參數錯誤";

            return redirect()->back()
                ->with('open_control_div', true)
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
        $order_item = 'App\Models\OrderItem'::find($request->input('order_item_id'));

        if ($this->getProductItemCanSellCount($order_item->product_item_id) <= 0) {
            $message_title = "減少失敗";
            $message_type = "error";
            $message = "目前庫存中" . $order_item->product_item_name . "存貨不足，故此已將此商品從購物車中移除";
            $order_item->delete();

            return redirect()->back()
                ->with('open_control_div', true)
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
        if ($order_item->count <= 1) {
            $message_title = "減少失敗";
            $message_type = "error";
            $message = "購買數量不能小於1";

            return redirect()->back()
                ->with('open_control_div', true)
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
        $order_item->update(['count' => $order_item->count - 1]);
        return redirect()->back()
            ->with('open_control_div', true);

    }
}
