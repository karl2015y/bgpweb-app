@extends('shop.layouts.master')

@section('body')

    <section class="container mx-auto px-4 mx-auto">
        <h1 class="text-center text-3xl font-bold ">訂單資訊</h1>

        <div class="flex justify-center mt-2" v-on:click="check_page_is_long()">
            <button v-on:click="orders.status_filter='all'"
                :class="orders.status_filter=='all'?'bg-gray-550 text-white border-0':'border-gray-550 border border-r-0'"
                class="w-24 text-center focus:outline-none py-2  ">
                全部狀態
            </button>
            <button v-on:click="orders.status_filter=['create']"
                :class="orders.status_filter.indexOf('create')>=0?'bg-gray-550 text-white border-0':'border-gray-550 border border-r-0'"
                class="w-24 text-center focus:outline-none  py-2 bg-white">
                未繳費
            </button>
            <button v-on:click="orders.status_filter=['paid', 'prePaid']"
                :class="orders.status_filter.indexOf('paid')>=0?'bg-gray-550 text-white border-0':'border-gray-550 border'"
                class="w-24 text-center focus:outline-none  py-2 bg-white">
                已付款
            </button>
        </div>

        <div class="hidden sm:flex w-full  justify-between  font-bold border-solid border-b border-gray-550 pb-3 mt-8">
            <div class="w-full sm:w-1/12 text-center border-solid border-gray-350 border-r">訂單編號</div>
            <div class="w-full sm:w-2/12 text-center border-solid border-gray-350 border-r">訂單狀態</div>
            <div class="w-full sm:w-3/12 text-center border-solid border-gray-350 border-r">收件資訊</div>
            <div class="w-full sm:w-3/12 text-center border-solid border-gray-350 border-r">購買明細</div>
            <div class="w-full sm:w-3/12 text-center">費用</div>
        </div>
        @forelse ($orders as $order)
            @if ($order->order_pay_price > 0)

                <div v-if="orders.status_filter=='all' || orders.status_filter.indexOf('{{ $order->status }}')>=0"
                    class="mt-3 mb-9 sm:my-0 block border-gray-350 border-solid hover:bg-gray-50 hover:shadow justify-between p-4 py-3 rounded shadow sm:border-b sm:flex sm:px-0 sm:shadow-none w-full">
                    <div
                        class="border-b border-gray-350 border-solid flex justify-between mb-2 pb-2 sm:block sm:border-b-0 sm:border-r sm:mb-0 sm:pb-0 sm:w-1/12 w-full">
                        <div class="block sm:hidden font-bold">訂單編號</div>
                        <div class=" text-right sm:text-center text-gray-350">No. {{ $order->id }}</div>
                    </div>
                    <div
                        class="border-b border-gray-350 border-solid flex justify-between mb-2 pb-2 sm:block sm:border-b-0 sm:border-r sm:mb-0 sm:pb-0 sm:w-2/12 w-full">
                        <div class="block sm:hidden font-bold">訂單狀態</div>
                        <div class=" text-right sm:text-center text-gray-350">
                            {{ $order->status_text ?? $order->status }}

                        </div>

                    </div>
                    <div
                        class="border-b border-gray-350 border-solid flex justify-between mb-2 pb-2 sm:block sm:border-b-0 sm:border-r sm:mb-0 sm:pb-0 sm:w-3/12 w-full">
                        <div class="block sm:hidden font-bold">收件資訊</div>
                        <div class=" text-right text-gray-350 sm:pr-2">
                            收件人姓名：{{ $order->receiver_name }} <br>
                            收件人電話：{{ $order->receiver_phone }} <br>
                            物流方式：{{ $order->ship_type_text ?? '基本物流' }} <br>
                            收件位置：{{ $order->receiver_address }} <br>
                        </div>
                    </div>
                    <div
                        class="border-b border-gray-350 border-solid flex justify-between mb-2 pb-2 sm:block sm:border-b-0 sm:border-r sm:mb-0 sm:pb-0 sm:w-3/12 w-full">
                        <div class="block sm:hidden font-bold">購買明細</div>
                        <div class=" text-right text-gray-350 sm:pr-2">
                            @foreach ($order->Items as $item)
                                <span>{{ $item->product_item_name }} X {{ $item->count }}</span> <br>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-between sm:block w-full sm:w-3/12">
                        <div class="block sm:hidden font-bold whitespace-nowrap">費用</div>
                        <div class=" text-right text-gray-350  sm:pr-2 w-full">
                            商品費用：{{ $order->all_product_price }}<br>
                            運費：{{ $order->ship_cost }} <br>
                            @if ($order->coupon_code)
                                優惠券折抵：{{ $order->coupon_discount }}({{ $order->coupon_code }}) <br>
                            @endif
                            實際支付：{{ $order->order_pay_price }} <br>
                            @if ($order->status == 'create')
                                <form action="{{ route('payAgain', ['order_id' => $order->id]) }}" method="POST">
                                    @csrf
                                    <button
                                        class="-ml-4 sm:w-32 sm:mx-0 sm:ml-auto bg-gray-550 border-0 flex focus:outline-none justify-center mt-4 mx-auto py-2 text-white w-full">
                                        立即結帳
                                    </button>

                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif


        @empty
            <p>No users</p>
        @endforelse
    </section>

@stop


@section('JS-content')
    @parent

    <script type="text/javascript">
        mixins.push({
            data: function() {
                return {
                    orders: {
                        status_filter: 'all'
                    }

                };
            },
            methods: {

            },
            created: function() {





            },
        })
    </script>

@stop
