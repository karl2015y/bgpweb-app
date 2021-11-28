@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '訂單管理')

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
                    <li class="text-gray-400">揀貨管理</li>
                </ol>
            </nav>

        </div>
        <div>
            <form class="hidden" ref="form_orders_Paid_PreOut" action="{{ route('ordersPaid2PreOut') }}"
                method="POST">
                @csrf

                <input name="filter_target" type="text" :value="filter_target">
                <input name="select_order_id_list" type="text" :value="selectOrderIdCount.map(item=>item[0]).toString()">
                <input type="submit">
            </form>
            <button v-on:click="checkSentOrNot()" v-if="filter_target=='ECPay'"
                class="btn btn-sec btn-rwd">批量綠界揀貨(@{{ selectOrderIdCount . length }})</button>
            <button v-on:click="checkSentOrNot()" v-else
                class="btn btn-sec btn-rwd">批量揀貨(@{{ selectOrderIdCount . length }})</button>
        </div>

    </div>
@stop

@section('content')
    {{-- 篩選器 --}}

    <form action="" method="get">
        <input class="hidden" id="changeTableStatus" type="submit" value="">
        <input class="hidden" v-model="filter_target" type="text" name="filter">
        <div v-on:click="clickFliter()" class="flex text-sm -ml-2 sm:ml-0 mb-3 sm:mb-0">
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
            <div class="border-r border-solid w-full text-center border-gray-200">
                <div>訂單編號</div>
                <button v-on:click="selectAllOrder()" class="btn-sm text-xs btn btn-fourth btn-rwd">
                    全選(@{{ selectOrderIdCount . length }}) </button>
            </div>
            <div class="border-r border-solid w-full text-center border-gray-200">綠界金流訂單編號</div>
            <div class="border-r border-solid w-full text-center border-gray-200">訂單狀態</div>
            <div class="border-r border-solid w-full text-center border-gray-200">收件資訊</div>
            <div class="border-r border-solid w-full text-center border-gray-200">購買明細</div>
            <div class="border-r border-solid w-full text-center border-gray-200">費用</div>
        </div>
        @forelse  ($orders as $order)
            {{-- content start --}}
            <div
                class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">訂單編號</div>
                        <div class=" flex justify-center text-gray-350">
                            <label class="flex items-center">
                                <input order_id="{{ $order->id }}" v-model="selectOrderIds['{{ $order->id }}']"
                                    v-on:click.once="selectOrderid('{{ $order->id }}')" type="checkbox"
                                    class="order_checkbox form-checkbox">
                                <span class="ml-2">No. {{ $order->id }}</span>
                            </label>

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
            {{-- content end --}}
        @empty
            <div class="border-solid border-gray-100 border rounded p-5 bg-white text-center mt-2 shadow-sm">目前沒有資料喔</div>
        @endforelse
    </div>


    {{ $orders->links() }}

@stop

@section('JS-content')
    @parent


    @if (session('order_RtnMsg'))
        <script type="text/javascript">
            Swal.fire({
                title: "已傳送",
                html: `
                @foreach (session('order_RtnMsg') as $key => $msg)
                    <div class="flex justify-around border-solid border-b border-gray-350 pb-2 mb-3">
                        <div class="w-4/12 text-center">No. {{ $key }}</div>
                        <div class="w-8/12 ">{{ $msg }}</div>
                    </div>
                @endforeach
                
                `,
            })
        </script>
    @endif


    <script>
        var app = new Vue({
            el: '#app',
            data: {
                filter_target: 'ECPay',
                filter_option: [{
                    val: 'ECPay',
                    text: '綠界物流',
                }, {
                    val: 'Owner',
                    text: '自訂物流',
                }, ],

                selectOrderIds: {}
            },

            computed: {
                selectOrderIdCount() {
                    return Object.entries(this.selectOrderIds).filter(item => item[1])
                },

            },

            created: function() {
                this.filter_target = this.getUrlQuery('filter') ? this.getUrlQuery('filter') : 'ECPay';
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
                },
                selectOrderid: function(order_id, status = true) {
                    this.$set(this.selectOrderIds, order_id, this.selectOrderIds[order_id])
                    this.selectOrderIds[order_id] = status;
                },
                selectAllOrder: function() {
                    const vm = this;
                    let status = vm.selectOrderIdCount.length != document.querySelectorAll(
                        'input.order_checkbox').length
                    document.querySelectorAll('input.order_checkbox').forEach((item) => {
                        item.checked = status;
                        vm.selectOrderid(item.getAttribute('order_id'), status);

                    })
                },

                checkSentOrNot: function() {
                    const vm = this;
                    if (vm.selectOrderIdCount == 0) {
                        Swal.fire('請先選擇訂單編號', '', 'info')
                        return;
                    }

                    Swal.fire({
                        title: '是否把改訂單狀態<br>改為「揀貨中」？',
                        text: `${vm.selectOrderIdCount.map(item=>'No. '+item[0]).toString()}`,
                        showCancelButton: true,
                        confirmButtonText: '是',
                        cancelButtonText: `否`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            vm.$refs.form_orders_Paid_PreOut.querySelector('input[type=submit]').click()
                        }
                    })
                }
            }
        })
    </script>

@stop
