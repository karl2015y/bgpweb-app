@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '出貨管理')

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
            <span>※ 訂單狀態「待付款」→「已付款(銀行驗證中)」→「已付款」→「揀貨中」→「已出貨」</span>
            <br>
            <span>※ 揀貨主要是告訴消費者，廠商已經確定該訂單的資訊，正在準備出貨</span>
            {{-- 麵包屑 --}}
            <nav class="col-span-2">
                <ol class="list-reset py-4 pl-2 rounded flex bg-grey-light text-grey">
                    <li><a href="{{ route('ordersPage') }}" class="no-underline text-blue-400">訂單列表</a></li>
                    <li class="px-2">/</li>
                    <li><a href="{{ route('ordersPreOut2OutPage') }}" class="no-underline text-blue-400">出貨管理</a></li>
                    <li class="px-2">/</li>
                    <li class="text-gray-400">訂單出貨</li>
                </ol>
            </nav>

        </div>


    </div>
@stop

@section('content')
    <div
        class="hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
        <div class="border-r border-solid w-full text-center border-gray-200">
            <div>訂單編號</div>

        </div>
        <div class="border-r border-solid w-full text-center border-gray-200">綠界金流訂單編號</div>
        <div class="border-r border-solid w-full text-center border-gray-200">訂單狀態</div>
        <div class="border-r border-solid w-full text-center border-gray-200">收件資訊</div>
        <div class="border-r border-solid w-full text-center border-gray-200">購買明細</div>
        <div class="border-r border-solid w-full text-center border-gray-200">費用</div>
    </div>

    {{-- content start --}}
    <div
        class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">
        <div
            class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
            <div class="flex justify-between lg:block mt-1.5">
                <div class="lg:hidden font-bold whitespace-nowrap">訂單編號</div>
                <div class=" flex justify-center text-gray-350">
                    <span class="ml-2">No. {{ $order->id }}</span>
                </div>

            </div>
        </div>
        <div
            class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
            <div class="flex justify-between lg:block mt-1.5">
                <div class="lg:hidden font-bold whitespace-nowrap">綠界金流訂單編號</div>
                <div class="text-right sm:text-center text-gray-350">
                    @if ($order->trade_no)
                        {{ $order->trade_no }}
                        <br>
                        付款時間：
                        <br>
                        {{ $order->pay_at }}
                    @else
                        尚未付款
                    @endif

                </div>
            </div>
        </div>
        <div
            class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
            <div class="flex justify-between lg:block mt-1.5 overflow-auto">
                <div class="lg:hidden font-bold whitespace-nowrap">訂單狀態</div>
                <div class=" text-right sm:text-center text-gray-350">
                    {{ $order->status_text ?? '' }}

                </div>
            </div>
        </div>
        <div
            class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200 ">
            <div class="flex justify-between lg:block mt-1.5">
                <div class="lg:hidden font-bold whitespace-nowrap">收件資訊</div>
                <div class=" text-right text-gray-350 sm:pr-2">
                    收件人姓名：{{ $order->receiver_name }} <br>
                    收件人電話：{{ $order->receiver_phone }} <br>
                    物流方式：{{ $order->ship_type_text ?? '基本物流' }} <br>
                    收件位置：{{ $order->receiver_address }} <br>
                </div>
            </div>


        </div>

        <div
            class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200 ">
            <div class="flex justify-between lg:block mt-1.5">
                <div class="lg:hidden font-bold whitespace-nowrap">購買明細</div>
                <div class=" text-right text-gray-350 sm:pr-2">
                    @foreach ($order->Items as $item)
                        <span>{{ $item->product_item_name }} X {{ $item->count }}</span> <br>
                    @endforeach
                </div>
            </div>


        </div>

        <div
            class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200 ">
            <div class="flex justify-between lg:block mt-1.5">
                <div class="lg:hidden font-bold whitespace-nowrap">結帳</div>
                <div class=" text-right text-gray-350  sm:pr-2 w-full">
                    商品費用：{{ $order->all_product_price }}<br>
                    運費：{{ $order->ship_cost }} <br>
                    @if ($order->coupon_code)
                        優惠券折抵：{{ $order->coupon_discount }}元({{ $order->coupon_code }}) <br>
                    @endif
                    實際支付：{{ $order->order_pay_price }} <br>

                </div>
            </div>


        </div>




    </div>


    <h1 class="text-2xl font-bold mt-8">出貨備註</h1>
    <form method="POST" action="">
        @csrf
        <label class="block text-left" style="max-width: 800px">
            <textarea name="note" class="form-textarea mt-1 block w-full shadow rounded p-1.5" rows="5"
                placeholder="輸入寄件備註，例如：寄件單號">{{$order->note}}</textarea>
        </label>
        <div class="w-full text-right">
            <button class="btn btn-fourth btn-rwd text-right">送出</button>
        </div>
    </form>


@stop

@section('JS-content')
    @parent




    <script>
        var app = new Vue({
            el: '#app',





        })
    </script>

@stop
