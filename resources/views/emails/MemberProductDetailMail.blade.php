<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] ?? 'DearMe 訂單狀態通知' }}</title>
</head>

<body>
    <p>
        親愛的貴賓您好：<br>
        以下為訂單明細，請您查閱。<br>
    <div>
        <div style="display: flex;justify-content: space-between;border-bottom: solid #ededed 1px;text-align: left;">
            <div style="width: 50%;">訂單編號</div>
            <div style="width: 50%;">No. {{ $details['order']->id }}</div>
        </div>
        <div style="display: flex;justify-content: space-between;border-bottom: solid #ededed 1px;text-align: left;">
            <div style="width: 50%;">訂單狀態</div>
            <div style="width: 50%;">
                {{ $details['order']->status_text ?? $details['order']->status }}

            </div>

        </div>
        <div style="display: flex;justify-content: space-between;border-bottom: solid #ededed 1px;text-align: left;">
            <div style="width: 50%;">收件資訊</div>
            <div style="width: 50%;">
                收件人姓名：{{ $details['order']->receiver_name }} <br>
                收件人電話：{{ $details['order']->receiver_phone }} <br>
                物流方式：{{ $details['order']->ship_type_text ?? '基本物流' }} <br>
                收件位置：{{ $details['order']->receiver_address }} <br>
            </div>
        </div>
        <div style="display: flex;justify-content: space-between;border-bottom: solid #ededed 1px;text-align: left;">
            <div style="width: 50%;">購買明細</div>
            <div style="width: 50%;">
                @foreach ($details['order']->Items as $item)
                    <span>{{ $item->product_item_name }} X {{ $item->count }}</span> <br>
                @endforeach
            </div>
        </div>
        <div style="display: flex;justify-content: space-between;border-bottom: solid #ededed 1px;text-align: left;">
            <div style="width: 50%;">費用</div>
            <div style="width: 50%;">
                商品費用：{{ $details['order']->all_product_price }}<br>
                運費：{{ $details['order']->ship_cost }} <br>
                @if ($details['order']->coupon_code)
                    優惠券折抵：{{ $details['order']->coupon_discount }}({{ $details['order']->coupon_code }}) <br>
                @endif
                實際支付：{{ $details['order']->order_pay_price }} <br>
                @if ($details['order']->status == 'create')
                    <form action="{{ route('payAgain', ['order_id' => $details['order']->id]) }}" method="POST">
                        @csrf
                        <button>
                            立即結帳(如果已收到付款成功的通知，請勿再次結帳)
                        </button>

                    </form>
                @endif
            </div>
        </div>

        <div style="display: flex;justify-content: space-between;border-bottom: solid #ededed 1px;text-align: left;">
            <div style="width: 50%;">買家備註</div>
            <div style="width: 50%;">
                {{ $details['order']->receiver_note == '' ? '無' : $details['order']->receiver_note }}
            </div>
        </div>
    </div>

    <div style="display: flex;justify-content: space-between;border-bottom: solid #ededed 1px;text-align: left;">
        <div style="width: 50%;">賣家備註</div>
        <div style="width: 50%;">
            {{ $details['order']->note == '' ? '無' : $details['order']->note }}
        </div>
    </div>
    </div>
    </p>

    @if ($details['user'])
        <p>
            <a href="{{ $details['orders_link'] }}">點擊這邊看看交易紀錄</a><br>
            若連結進不去可以複製以下連結<br>
            {{ $details['orders_link'] }}
        </p>
    @else
        <p>
            我們發現您還未填寫顧客資料，如果需要查詢訂單，請先做身分登記，請放心這個步驟不會花費您太多時間，且該資料僅用於驗證，不會有其他用途，請您放心。<br>
            <a href="{{ $details['register_link'] }}">點擊此處驗證</a><br>
            若連結進不去可以複製以下連結<br>
            {{ $details['register_link'] }}
        </p>


    @endif


    <p>
        DearMe 全體敬上
    </p>
</body>

</html>
