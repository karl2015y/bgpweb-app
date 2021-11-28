@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name')
@if ($email)
<a class="text-base text-blue-500" href="{{route('admin_member.index', ['keyword'=>$email])}}">返回會員管理</a>
訂單管理({{$email}})
@else
訂單管理
@endif
@stop

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
            <span>※ 訂單狀態「待付款」→「已付款(銀行驗證中)」→「已付款」→「揀貨中」→「已出貨」</span>
        </div>
        <div>
            <a href="{{ route('ordersPaid2PreOutPage') }}" class="btn btn-main btn-rwd">揀貨管理</a>
            <a href="{{ route('ordersPreOut2OutPage') }}" class="btn btn-sec btn-rwd">出貨管理</a>
        </div>

    </div>
@stop

@section('content')
    {{-- 篩選器 --}}

    <form action="" method="get">
        <input class="hidden" id="changeTableStatus" type="submit" value="">
        <input class="hidden" v-model="filter_target" type="text" name="filter">
        <input class="hidden" value="{{$email}}" type="text" name="email">
        <div ref="filter" v-on:click="clickFliter()" class="flex text-sm overflow-x-auto mb-3 sm:mb-0">
            <template v-for="(item, index) in filter_option">
                <div v-if="index==0" v-on:click="filter_target=item.val"
                    :class="filter_target==item.val?'bg-blue-500 text-white border-blue-500':''"
                    class="whitespace-nowrap inline-flex rounded-l-lg border border-double border-r-0 border-gray-300 radio text-center self-center py-1 px-4  cursor-pointer ">
                    @{{ item . text }}
                </div>

                <div v-else-if="index == filter_option.length - 1" v-on:click="filter_target=item.val"
                    :class="filter_target==item.val?'bg-blue-500 text-white border-blue-500':''"
                    class="whitespace-nowrap inline-flex rounded-r-lg  border border-double border-gray-300 radio text-center self-center py-1 px-4  cursor-pointer ">
                    @{{ item . text }}
                </div>
                <div v-else v-on:click="filter_target=item.val"
                    :class="filter_target==item.val?'bg-blue-500 text-white border-blue-500':''"
                    class="whitespace-nowrap inline-flex border border-double border-r-0 border-gray-300 radio text-center self-center py-1 px-4  cursor-pointer ">
                    @{{ item . text }}
                </div>
            </template>


        </div>
    </form>


    {{ $orders->links() }}



    <div class="my-2">

        {{-- title --}}
        <div
            class="hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
            <div class="border-r border-solid w-full text-center border-gray-200">訂單編號</div>
            <div class="border-r border-solid w-full text-center border-gray-200">綠界金流訂單編號</div>
            <div class="border-r border-solid w-full text-center border-gray-200">訂單狀態</div>
            <div class="border-r border-solid w-full text-center border-gray-200">收件資訊</div>
            <div class="border-r border-solid w-full text-center border-gray-200">購買明細</div>
            <div class="border-r border-solid w-full text-center border-gray-200">費用</div>
            {{-- <div class="w-full text-center border-gray-200">操作</div> --}}
        </div>
        @forelse  ($orders as $order)
            {{-- content start --}}
            <div
                class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">訂單編號</div>
                        <div class=" text-right sm:text-center text-gray-350">No. {{ $order->id }}</div>

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
                            <p class="whitespace-pre-line">
                             {{ $order->note ?? '' }}
                            </p>
                           
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


                {{-- <div class="w-full text-center border-gray-200">

                    <div class="w-full mt-3 ">
                        <button class="btn btn-main btn-rwd">
                            修改狀態
                        </button>
                    </div>

                </div> --}}


            </div>
            {{-- content end --}}
        @empty
            <div class="border-solid border-gray-100 border rounded p-5 bg-white text-center mt-2 shadow-sm">目前沒有資料喔</div>
        @endforelse
    </div>


    {{ $orders->links() }}

@stop

@section('JS-content')
    @parent
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                filter_target: 'all',
                filter_option: [{
                        val: 'all',
                        text: '全部',
                    }, {
                        val: 'create',
                        text: '待付款',
                    },
                    {
                        val: 'prePaid',
                        text: '已付款(銀行驗證中)',
                    },
                    {
                        val: 'paid',
                        text: '已付款',
                    },
                    {
                        val: 'preOut',
                        text: '揀貨中',
                    },
                    {
                        val: 'outed',
                        text: '已出貨',
                    },

                ]
            },
            created: function() {
                const vm = this;
                vm.filter_target = vm.getUrlQuery('filter') ? vm.getUrlQuery('filter') : 'all';
                vm.$nextTick(() => {
                    const leftPX = document.querySelector('div.bg-blue-500.text-white.border-blue-500')
                        .offsetLeft
                    vm.$refs.filter.scrollTo(leftPX - 60, 0)
                })

            },
            methods: {
                clickFliter: function() {
                    document.querySelector('#changeTableStatus').click()
                },
                getUrlQuery: function(query) {
                    const urlSearchParams = new URLSearchParams(window.location.search);
                    const params = Object.fromEntries(urlSearchParams.entries());
                    if (params[query]) {
                        return params[query];
                    }
                    return '';

                }
            }
        })
    </script>

@stop
