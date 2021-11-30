<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberCenterController extends Controller
{
    public function registerPage(Request $request)
    {
        $data = [];
        try {
            $data['email'] = $request->input('email');
            if ($data['email'] == 'App\Models\Order'::where('session_id', $request->input('code'))->first()->receiver_email) {
                return view('shop.member.signup', $data);
            }else{
                $request->input('error')['toerror'];
            }
        } catch (\Throwable $th) {
            $message_title = "失敗";
            $message_type = "error";
            $message = "資料比對錯誤，如持續出現該錯誤，請直接連絡客服，工程師打屁屁";
            return redirect('/')
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required|confirmed',
        ], [
            'email.required' => ':attribute為必填',
            'email.email' => ':attribute的格式錯誤',
            'password.required' => ':attribute為必填',
            'password.confirmed' => ':attribute重複錯誤',
            'name.required' => ':attribute為必填',

        ], [
            'email' => '電子信箱(帳號)',
            'password' => '密碼',
            'name' => 'Instagram帳號(IG)',
        ]);
        $rep = $request->input();

        // 確認是否存在在User表裡
        $user = 'App\Models\User'::where('email', $validatedData['email'])->first();
        if ($user == NULL) {
            // 新增至User表
            $user = 'App\Models\User'::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password'])
            ]);
        } else {
            $message_title = "驗證失敗";
            $message_type = "error";
            $message = "此email已驗證過，嘗試登入看看吧，真的不行就試試看重製密碼";
            return redirect()->route('loginPage',  ['email' => $validatedData['email']])
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }

        $message_title = "驗證成功";
        $message_type = "success";
        $message = "使用剛剛設定的密碼來登入看看吧~";
        return redirect()->route('loginPage',  ['email' => $validatedData['email']])
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }
    public function loginPage(Request $request)
    {
        // 確認是否登入
        if ($request->user()) {
            return redirect()->route('myOrderPage');
        }
        if (!$request->exists('email')) {
            $data = [
                'email' => '',
                'hasHistory' => false,
                'isRegistered' => false,
            ];
            return view('shop.member.login', $data);
        }
        $rep = $request->input();
        // 預設都是未消費與未註冊過的人
        $data = [
            'email' => $rep['email'],
            'hasHistory' => false,
            'isRegistered' => false,
        ];

        // 確認在Order表中有無紀錄(有消費過的人，但沒有註冊過)
        // $data = [
        //     'email' => 'karl2015y@gmail.com',
        //     'hasHistory' => true,
        //     'isRegistered' => false,
        // ];
        $data['hasHistory'] = 'App\Models\Order'::where('receiver_email', $rep['email'])->count() > 0;

        // 確認user表中是否有註冊(有消費過的人，且有註冊過)
        // $data = [
        //     'email' => 'karl2015y@gmail.com',
        //     'hasHistory' => true,
        //     'isRegistered' => true,
        // ];
        $data['isRegistered'] = 'App\Models\User'::where('email', $rep['email'])->count() > 0;

        if ($data['hasHistory'] &&  !$data['isRegistered']) {
            $details = [
                'link' => route('registerPage', ['email' => $rep['email'], 'code' => 'App\Models\Order'::where('receiver_email', $rep['email'])->first()->session_id]),
            ];
            '\Mail'::to($rep['email'])->send(new \App\Mail\MemberSignUpMail($details));
            // '\Mail'::to('karl2015y@gmail.com')->send(new \App\Mail\MemberSignUpMail($details));

        }

        return view('shop.member.login', $data);
    }
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => ':attribute為必填',
            'email.email' => ':attribute格式錯誤',
            'password.required' => ':attribute為必填',
        ], [
            'email' => '電子信箱',
            'password' => '密碼',
        ]);

        $remember_me = $request->has('remember-me') ? true : false;
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {
            $message_title = "登入成功";
            $message_type = "success";
            $message = "歡迎回來";
            return redirect()->route('myOrderPage')
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        } else {
            $message_title = "登入失敗";
            $message_type = "error";
            $message = "帳號或密碼錯誤";
            return redirect()->route('loginPage', ['email' => $request->input('email'), 'remember_me' => $remember_me])
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }


        return $validatedData;
    }

    public function myOrderPage(Request $request)
    {
        // 確認是否登入
        if (!$request->user()) {
            $message_title = "授權失敗";
            $message_type = "error";
            $message = "請先登入";
            return redirect()->route('loginPage')
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
        $orders = $request->user()->Orders;
        $status_list = [
            'create' => '訂單已建立，已為您保留商品，請在三日內付款。',
            'prePaid' => '已付款(銀行端查核中)',
            'paid' => '已付款，準備寄出。',
            'delay' => '超時支付',
            'preOut' => '揀貨中，準備寄出。',
            'outed' => '已出貨',
        ];
        $ship_types = [
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

        foreach ($orders as $order) {
            $order->status_text = $status_list[$order->status] ?? null;
            $order->ship_type_text = $ship_types[$order->ship_type] ?? null;
        }

        $data = [
            'orders' => $orders,
        ];
        // return $data;

        return view('shop.member.MyOrders', $data);
    }


    public function payAgain($order_id)
    {
        $order = 'App\Models\Order'::where('id', $order_id)->where('status', 'create')->with('Items')->first();
        $items_name = '';
        foreach ($order->Items as $item) {
            // $items_name = $items_name . $item->product_item_name .' '. $item->product_item_price .'元 X'. $item->count .'#';
            $items_name = $items_name . $item->product_item_name . ' X' . $item->count . '#';
        }


        return (new ECPayPaymentController())->sendOrder($order->receiver_email, "DearMe", $items_name, $order->order_pay_price, $order->id);
    }
}
