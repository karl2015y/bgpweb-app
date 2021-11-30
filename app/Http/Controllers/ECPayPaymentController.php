<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TsaiYiHua\ECPay\Checkout;
use TsaiYiHua\ECPay\Collections\CheckoutPostCollection;
use TsaiYiHua\ECPay\Services\StringService;


class ECPayPaymentController extends Controller
{
    protected $checkout;
    public $SC;

    public function __construct()
    {
        $this->SC = new SettingController;
        config(['ecpay.MerchantId' => $this->SC->get('ecpay_MerchantID')]);
        config(['ecpay.HashKey' => $this->SC->get('ecpay_HashKey')]);
        config(['ecpay.HashIV' => $this->SC->get('ecpay_HashIV')]);
        $this->checkout = new Checkout(new CheckoutPostCollection());
        // Client POST
        $this->checkout->setReturnUrl(route('checkoutCallback'));
        // $this->checkout->setReturnUrl('');
        // Server POST
        $this->checkout->setNotifyUrl(route('checkoutServerCallback'));
    }

    public function sendOrder($UserId, $ItemDescription, $ItemName, $TotalAmount, $OrderId)
    {
        $formData = [
            'UserId' => $UserId, // 用戶ID , Optional
            'ItemDescription' => $ItemDescription,
            'ItemName' => $ItemName,
            'TotalAmount' => $TotalAmount,
            'PaymentMethod' => 'ALL', // ALL, Credit, ATM, WebATM
            'CustomField1' => $OrderId, //自定義欄位1
            'CustomField2' => $UserId, //自定義欄位1
            'ClientBackURL' => route("HomePage") //Client 端返回特店的按鈕連結

        ];
        return $this->checkout->setPostData($formData)->send();
    }


    //綠界付完款轉址路由方法
    public function checkoutCallback(Request $request)
    {
        $response = $request->all();
        // return $response;
        $order = 'App\Models\Order'::find($response['CustomField1']);
        if ($response['RtnCode'] == 1) {
            if ($response['PaymentType'] == 'Credit_CreditCard') {
                $order->pay_type = 'credit';
            }
            $order->trade_no = $response['TradeNo']; //綠界訂單編號
            $order->pay_at = 'Carbon\Carbon'::now();
            $order->status = 'prePaid';
            $order->save();
            // Log::info('訂單編號' . $order->id . '付款成功');
            
        } else {
            // Log::error('訂單編號' . $order->id . '付款失敗');
        }

        $message_title = "付款成功";
        $message_type = "success";
        $message = "感謝您的購買，這是您的訂單編號 No." . $response['CustomField1'] . "，不需要記憶，若需要查看訂單資訊，請點擊網頁右上角的訂單資訊(手機用戶請點擊左上角的Menu按鈕，即可看到訂單資訊)，輸入Email即可。同時，我們也已經將這次消費資訊寄至您的Email(" . $response['CustomField2'] . ')，麻煩您查收，後續訂單出貨時會再次寄送。若有任何問題，懇請您聯絡客服，我們會馬上會您處理，再次謝謝您對我們的支持。';
        return redirect('/')->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }


    //綠界金流server Callback
    public function checkoutServerCallback(Request $request)
    {
        $serverPost = $request->post();
        $checkMacValue = $request->post('CheckMacValue');



        $checkCode = $this->generate($serverPost, '5294y06JbISpM5x9', 'v77hoKGq4kWxNNIS');
        if ($checkMacValue ==  $checkCode) {
            $order = 'App\Models\Order'::find($serverPost['CustomField1']);
            $order->status = 'paid';
            // $order->status = 'prePaid';
            $order->save();

            $details = [
                'title' => 'DearMe 已付款通知(馬上就可以拿到商品啦 開勳~~)',
                'user' => 'App\Models\User'::where('email', $order['receiver_email'])->first(),
                'register_link' =>  route('registerPage', ['email' => $order['receiver_email'], 'code'=> $order->session_id]), 
                'orders_link' => route('myOrderPage'), 
                'order' => $order,
                'order_items' => $order->Items,
            ];

   

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




            return '1|OK';
        } else {
            return '0|FAIL';
        }
    }

    public function generate(array $params, $hashKey, $hashIV, $encType = 1)
    {
        // 0) 如果資料中有 null，必需轉成空字串
        $params = array_map('strval', $params);

        // 1) 如果資料中有 CheckMacValue 必需先移除
        unset($params['CheckMacValue']);

        // 2) 將鍵值由 A-Z 排序
        uksort($params, 'strcasecmp');

        // 3) 將陣列轉為 query 字串
        $paramsString = urldecode(http_build_query($params));

        // 4) 最前方加入 HashKey，最後方加入 HashIV
        $paramsString = "HashKey={$hashKey}&{$paramsString}&HashIV={$hashIV}";

        // 5) 做 URLEncode
        $paramsString = urlencode($paramsString);

        // 6) 轉為全小寫
        $paramsString = strtolower($paramsString);

        // 7) 轉換特定字元
        $paramsString = str_replace('%2d', '-', $paramsString);
        $paramsString = str_replace('%5f', '_', $paramsString);
        $paramsString = str_replace('%2e', '.', $paramsString);
        $paramsString = str_replace('%21', '!', $paramsString);
        $paramsString = str_replace('%2a', '*', $paramsString);
        $paramsString = str_replace('%28', '(', $paramsString);
        $paramsString = str_replace('%29', ')', $paramsString);

        // 8) 進行編碼
        $paramsString = $encType ? hash('sha256', $paramsString) : md5($paramsString);

        // 9) 轉為全大寫後回傳
        return strtoupper($paramsString);
    }
}
