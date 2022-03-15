<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminOrderController extends Controller
{

    protected $status_list;
    protected $ship_types;

    public function __construct()
    {
        $this->status_list = [
            'create' => '訂單已建立，已為您保留商品，請在三日內付款。',
            'prePaid' => '已付款(銀行端查核中)',
            'paid' => '已付款，準備商品。',
            'preOut' => '揀貨中，準備寄出。',
            'outed' => '已出貨',
        ];
        $this->ship_types = [
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
    }

    public function ordersPage(Request $request)
    {
        $filter = $request['filter'] ?? 'all';
        $orders = 'App\Models\Order'::where('order_pay_price', '>', 0)->with('Items');
        if ($filter != 'all') {
            $orders = $orders->where('status', $filter);
        } else {
            $orders = $orders->where('status', '<>', "preCreate")->where('status', '<>', "fail");
        }

        $email = $request->input('email') ?? '';
        if ($email) {
            $orders->where('receiver_email', $email);
        }


        $orders = $orders->paginate(10);
        $orders->appends(['filter' => $filter, 'email' => $email]);

        foreach ($orders as $order) {
            $order->status_text = $this->status_list[$order->status] ?? $order->status;
            $order->ship_type_text = $this->ship_types[$order->ship_type] ?? $order->ship_type;
        }

        $data = [
            'orders' => $orders,
            'email' => $email,
        ];
        // return $data;
        return view('admin.orders.ordersPage', $data);
    }

    public function order2Fail()
    {
        $threeDaysAgo = 'Carbon\Carbon'::now()->subDays(3);
        'App\Models\Order'::where('updated_at', '<', $threeDaysAgo)->where('status', 'create')->update(['status' => 'fail']);
    }


    // 訂單列表 - 已付款2揀貨中
    public function ordersPaid2PreOutPage(Request $request)
    {
        $filter = $request['filter'] ?? 'ECPay';
        $orders = 'App\Models\Order'::where('order_pay_price', '>', 0)->with('Items');
        $orders = $orders->where('status', 'Paid');

        if ($filter == 'Owner') {
            $orders = $orders->where('ship_type', 'owner_shipping');
        } else {
            $orders = $orders->where('ship_type', '<>', 'owner_shipping');
        }

        $orders = $orders->paginate(10);
        $orders->appends(['filter' => $filter]);


        foreach ($orders as $order) {
            $order->status_text = $this->status_list[$order->status] ?? $order->status;
            $order->ship_type_text = $this->ship_types[$order->ship_type] ?? $order->ship_type;
        }

        $data = [
            'orders' => $orders,
        ];
        // return $data;
        return view('admin.orders.ordersPaid2PreOutPage', $data);
    }
    // 訂單狀態批量改為「揀貨中」
    public function ordersPaid2PreOut(Request $request)
    {
        $filter_target = $request['filter_target'] ?? 'Owner';
        $select_order_id_list = explode(",", $request['select_order_id_list'] ?? '');
        $order_RtnMsg = [];
        if ($filter_target == 'ECPay') {
            foreach ($select_order_id_list as $order_id) {
                $order = 'App\Models\Order'::find($order_id);
                $TempLogisticsID = $order->logistics_id;
                $ECP_res = (new ECPayLogisticsController())->CreateByTempTrade($TempLogisticsID, $order->id);
                $order_RtnMsg[$order_id] = $ECP_res['RtnMsg'];
                if ($ECP_res['RtnCode'] == 1) {
                    $order->logistics_id = $ECP_res['LogisticsID'];
                    $order->status = 'preOut';
                    $order->save();
                }
            }
            return redirect()->route('ordersPaid2PreOutPage')->with('order_RtnMsg', $order_RtnMsg);
        } else {
            foreach ($select_order_id_list as $order_id) {
                $order = 'App\Models\Order'::find($order_id);
                $order_RtnMsg[$order_id] = '成功';
                $order->status = 'preOut';
                $order->save();
            }
            return redirect()->route('ordersPaid2PreOutPage', ['filter' => 'Owner'])->with('order_RtnMsg', $order_RtnMsg);
        }
    }
    // 訂單列表 - 揀貨中2已出貨
    public function ordersPreOut2OutPage(Request $request)
    {
        $filter = $request['filter'] ?? 'HOME_TCAT';
        $orders = 'App\Models\Order'::where('order_pay_price', '>', 0)->with('Items');
        $orders = $orders->where('status', 'preOut');

        if ($filter == 'Owner') {
            $orders = $orders->where('ship_type', 'owner_shipping');
        } else {
            $orders = $orders->where('ship_type', $filter);
        }

        $orders = $orders->paginate(10);
        $orders->appends(['filter' => $filter]);


        foreach ($orders as $order) {
            $order->status_text = $this->status_list[$order->status] ?? $order->status;
            $order->ship_type_text = $this->ship_types[$order->ship_type] ?? $order->ship_type;
        }

        $data = [
            'orders' => $orders,
        ];
        // return $data;
        return view('admin.orders.ordersPreOut2OutPage', $data);
    }

    public function printOrderShippingData(Request $request)
    {
        $filter_target = $request['filter_target'] ?? 'Owner';
        if ($filter_target != 'Owner') {
            $LogisticsSubType = explode("_", $filter_target)[1];
            $select_order_id_list = explode(",", $request['select_order_id_list'] ?? '');
            $LogisticsIDs = [];
            $tmp_LogisticsIDs = 'App\Models\Order'::whereIn('id', $select_order_id_list)->get('logistics_id');
            foreach ($tmp_LogisticsIDs as $item) {
                array_push($LogisticsIDs, $item->logistics_id);
            }
            $ECP_res = (new ECPayLogisticsController())->PrintTradeDocument($LogisticsSubType, $LogisticsIDs);
            return view('admin.orders.printOrder', ['printData' => $ECP_res]);
            // return redirect()->route('ordersPreOut2OutPage', ['filter' => $filter_target])->with('printData', $ECP_res);
        }

        // return $LogisticsIDs;
    }

    // 訂單狀態改為「已出貨」
    public function orderSinglePreOut2OutPage(Request $request)
    {
        $order_id = $request['o_id'] ?? null;
        if (!$order_id) {
            $message_title = "參數錯誤";
            $message_type = "error";
            $message = "參數錯誤";
            return redirect()->back()
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
        $order = 'App\Models\Order'::find($order_id);
        $order->status_text = $this->status_list[$order->status] ?? $order->status;
        $order->ship_type_text = $this->ship_types[$order->ship_type] ?? $order->ship_type;
        $data = [
            'order' => $order
        ];
        return view('admin.orders.orderSinglePreOut2OutPage', $data);
    }

    public function orderSinglePreOut2Out(Request $request)
    {

        $order_id = $request['o_id'] ?? null;
        $note = $request['note'] ?? null;
        if (!$order_id || !$note) {
            $message_title = "參數錯誤";
            $message_type = "error";
            $message = "參數錯誤";
            return redirect()->back()
                ->with('message_title', $message_title)
                ->with('message_type', $message_type)
                ->with('message', $message);
        }
        $order = 'App\Models\Order'::find($order_id);
        $order->status = 'outed';
        $order->note = $note;
        $order->save();


        $details = [
            'title' => 'DearMe 出貨通知(您的支持就是我們最大的動力!!!!)',
            'user' => 'App\Models\User'::where('email', $order['receiver_email'])->first(),
            'register_link' =>  route('registerPage', ['email' => $order['receiver_email'], 'code' => $order->session_id]),
            'orders_link' => route('myOrderPage'),
            'order' => $order,
            'order_items' => $order->Items,
        ];


        $details['order']->status_text = $this->status_list[$details['order']->status];
        $details['order']->ship_type_text = $this->ship_types[$details['order']->ship_type];

        '\Mail'::to($order['receiver_email'])->send(new \App\Mail\MemberProductDetailMail($details));


        return redirect()->back();
    }
}
