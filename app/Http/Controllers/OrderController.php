<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{

    // 商城結帳
    public function checkoutPage()
    {
        $order =  (new CartController())->getCartDatas();
        if ($order->coupon_code) {
            $coupon_can_use_resp = $this->checkCouponCanUse($order->coupon_code);
            if ($coupon_can_use_resp['status']) {
                $coupon = $coupon_can_use_resp['coupon'];
                $order = $this->computCoupon($coupon, $order);
            } else {
                $order = $this->cancelCoupon($order);
            }
        }
        $data = [
            'order' => $order
        ];

        // return $data;
        return view('shop.checkout', $data);
    }


    // 確認優惠券是否能使用
    public function checkCouponCanUse($coupon_code)
    {
        $now = 'Carbon\Carbon'::now();
        $coupon = 'App\Models\Coupon'::where('code', $coupon_code)->where('start_at', '<=', $now)->where('end_at', '>', $now)->first();
        if ($coupon == null) {
            return ['status' => false, 'msg' => '序號不存在，或該優惠券時間尚未開放'];
        }
        $order =  (new CartController())->getCartDatas();
        if ($order->all_product_price < $coupon->minimum_price) {
            return ['status' => false, 'msg' => '該優惠券最低需要消費' . $coupon->minimum_price . '元'];
        }
        // 確認是否有特定商品
        $product_id_in_order = false;
        if ($coupon->product_id) {
            foreach ($order->Items as $item) {
                if ($item->Product_Item->Product->id == $coupon->product_id) {
                    $product_id_in_order = true;
                    break;
                }
            }
        }
        if ($coupon->product_id && !$product_id_in_order) {
            return ['status' => false, 'msg' => '該優惠券需要搭配特定商品使用，請詳閱以下說明：' . $coupon->description];
        }
        return ['status' => true, 'coupon' => $coupon];
    }
    // 計算優惠眷
    public function computCoupon($coupon, $order)
    {
        $order->coupon_code = $coupon->code;
        if ($coupon->type == 'discount') {
            $order->coupon_discount = $coupon->number;
        } else if ($coupon->type == 'percent' && (1 - $coupon->number) > 0) {
            $order->coupon_discount = round((1 - $coupon->number) * $order->all_product_price);
        }
        $order->save();
        return (new CartController())->getCartDatas();
    }
    // 使用優惠券
    public function useCoupon(Request $request)
    {
        $coupon_code = $request->input('coupon_code');
        $coupon_can_use_resp = $this->checkCouponCanUse($coupon_code);
        if (!$coupon_can_use_resp['status']) {
            $message_title = "優惠券失敗";
            $message_type = "error";
            $message = $coupon_can_use_resp['msg'];
            return redirect()->back()
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
        $coupon = $coupon_can_use_resp['coupon'];
        $order =  (new CartController())->getCartDatas();
        $this->computCoupon($coupon, $order);
        $message_title = "已加優惠券";
        $message_type = "success";
        $message = '感謝您使用優惠券';
        return redirect()->back()
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }

    // 取消優惠券
    public function cancelCoupon($order)
    {
        $order->coupon_code = '';
        $order->coupon_discount = 0;
        $order->save();
        return (new CartController())->getCartDatas();
    }
    public function userCancelCoupon(Request $request)
    {
        $order =  (new CartController())->getCartDatas();
        $this->cancelCoupon($order);
        $message_title = "已取消使用優惠券";
        $message_type = "success";
        $message = '精打細算的你，換張優惠券吧';
        return redirect()->back()
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }

    // 選擇物流
    public function shippingSelectionPage(Request $request)
    {
        $order =  (new CartController())->getCartDatas();
        // if ($order->coupon_code) {
        //     $coupon_can_use_resp = $this->checkCouponCanUse($order->coupon_code);
        //     if ($coupon_can_use_resp['status']) {
        //         $coupon = $coupon_can_use_resp['coupon'];
        //         $order = $this->computCoupon($coupon, $order);
        //     } else {
        //         $order = $this->cancelCoupon($order);
        //     }
        // }
        $data = [
            'order' => $order
        ];

        // return $data;
        return view('shop.shippingSelection', $data);
    }
    public function shippingSelection(Request $request)
    {
        // return $request->input();
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'county' => 'required',
            'district' => 'required',
            'zipcode' => 'required',
            'address' => 'required',
        ], [
            'name.required' => ':attribute為必填',
            'phone.required' => ':attribute為必填',
            'county.required' => ':attribute不完整',
            'district.required' => ':attribute不完整',
            'zipcode.required' => ':attribute不完整',
            'address.required' => ':attribute不完整',
        ], [
            'name' => '收件人姓名',
            'phone' => '收件人電話',
            'county' => '收件人地址',
            'district' => '收件人地址',
            'zipcode' => '收件人地址',
            'address' => '收件人地址',
        ]);


        $order =  (new CartController())->getCartDatas();
        $order->ship_type = 'owner_shipping';
        $order->ship_cost = 120;
        $order->receiver_name = $request->name;
        $order->receiver_phone = $request->phone;
        $order->receiver_address = $request->zipcode . $request->county . $request->district . $request->address;
        $order->save();
        $data = [
            'order' => $order
        ];

        // return $data;
        return redirect()->route('checkAndPayPage');
    }

    //確認並準備付款
    public function checkAndPayPage(Request $request)
    {
        $order =  (new CartController())->getCartDatas();
        if ($order->coupon_code) {
            $coupon_can_use_resp = $this->checkCouponCanUse($order->coupon_code);
            if ($coupon_can_use_resp['status']) {
                $coupon = $coupon_can_use_resp['coupon'];
                $order = $this->computCoupon($coupon, $order);
            } else {
                $order = $this->cancelCoupon($order);
            }
        }
        $data = [
            'order' => $order
        ];

        // return $data;
        return view('shop.checkAndPayPage', $data);
    }


    public function payPage(Request $request){

        $validatedData = $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => '請務必填寫正確的:attribute，確保後續訂單資訊，能準確的傳達給您！',            
            'email.email' => '請務必填寫正確的:attribute，確保後續訂單資訊，能準確的傳達給您！',            
        ], [
            'email' => '訂單通知 Email',          
        ]);

        $order =  (new CartController())->getCartDatas();
        $order->status = "create";
        $order->receiver_email = $request->email;
        if($request->message){
            $order->receiver_note = $request->message;
        }
        foreach ($order->Items as $item) {
            $item->Product_Item()->update([
                'count' => $item->Product_Item->count - $item->count
            ]);
        }
        $order->save();

        $details = [
            'title' => 'DearMe 下單通知(內有連結可以直接付款)',
            'user' => 'App\Models\User'::where('email', $order['receiver_email'])->first(),
            'orders_link' => route('myOrderPage'), 
            'order' => $order,
            'order_items' => $order->Items,
        ];
        if($details['user']){
            $details['register_link'] = route('registerPage', ['email' => $order['receiver_email'], 'code'=> $details['user']->session_id]);
        }
        $status_list = [
            'create' => '訂單已建立，已為您保留商品，請在三日內付款。',
            'prePaid' => '已付款(銀行端查核中)',
            'paid' => '已付款，準備寄出。',
            'delay' => '超時支付',
            'preOut' => '揀貨中，準備寄出。',
            'outed' => '已出貨',
        ];
        $ship_types = [
            'owner_shipping' => '基本物流',
            'HOME_TCAT' => '黑貓物流',
            'HOME_ECAN' => '宅配通',
            'CVS_FAMIC2C' => '全家物流',
            'CVS_UNIMARTC2C' => '7-ELEVEN 超商物流',
            'CVS_HILIFEC2C' => '萊爾富物流',
            'CVS_OKMARTC2C' => 'OK 超商',
            'CVS_FAMI' => '全家物流',
            'CVS_UNIMART' => '7-ELEVEN 超商物流',
            'CVS_HILIFE' => '萊爾富物流',
            'CVS_OKMART' => 'OK 超商',
        ];
        $details['order']->status_text=$status_list[$details['order']->status];
        $details['order']->ship_type_text=$ship_types[$details['order']->ship_type];

        '\Mail'::to($order['receiver_email'])->send(new \App\Mail\MemberProductDetailMail($details));


        session()->regenerate();

        $items_name = '';

        foreach ($order->Items as $item) {
            // $items_name = $items_name . $item->product_item_name .' '. $item->product_item_price .'元 X'. $item->count .'#';
            $items_name = $items_name . $item->product_item_name .' X'. $item->count .'#';
        }


        return (new ECPayPaymentController())->sendOrder($request->email, "DearMe", $items_name, $order->order_pay_price, $order->id);

        $data = [
            'order' => $order,
            'MerchantTradeNo' => $order->id,
            'items_name' => $items_name,
            'TotalAmount' =>  $order->order_pay_price,
        ];

        return $data;
    }


    public function makeDelayOrderCountBack2Product(){
        $deadline = 'Carbon\Carbon'::now()->subDays(3);
        // $deadline = 'Carbon\Carbon'::now()->subMinutes(1);
        $orders = 'App\Models\Order'::where('updated_at', '<', $deadline)->where('status','create')->get();
        foreach ($orders as $order) {
            $order->update(['status'=>'delay']);
            foreach ($order->Items as $item) {
                if($item->Product_Item){
                    $item->Product_Item()->update([
                        'count' => $item->Product_Item->count + $item->count
                    ]);
                }

            }

        }
    }
}
