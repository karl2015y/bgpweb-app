@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '優惠券管理')

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
            <span>※ 訂單狀態「待付款」→「已付款(銀行驗證中)」→「已付款」→「揀貨中」→「已出貨」</span>
            <br>
            <span>※ 揀貨主要是告訴消費者，廠商已經確定該訂單的資訊，正在準備出貨</span>
            {{-- 麵包屑 --}}
            <nav class="col-span-2">
                <ol class="list-reset py-4 pl-2 rounded flex bg-grey-light text-grey">
                    <li><a href="{{ route('coupon.index') }}" class="no-underline text-blue-400">優惠券列表</a></li>
                    <li class="px-2">/</li>
                    <li class="text-gray-400">{{ $coupon->title }}</li>
                </ol>
            </nav>

        </div>
        <div>
            <a href="{{ route('coupon.edit', $coupon->id) }}">
                <button class="btn btn-sec btn-rwd">編輯</button>
            </a>

            <button v-on:click="checkDeleteOrNot()" class="btn btn-third btn-rwd">刪除</button>
            <form ref="form_delete_edit" method="POST" action="{{ route('coupon.destroy', [$coupon->id]) }}">
                @csrf
                @method('Delete')

                <input type="submit" class="hidden">
            </form>
        </div>

    </div>
@stop

@section('content')



    <div class="my-2">

        {{-- title --}}
        <div
            class="hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
            <div class="border-r border-solid w-full text-center border-gray-200">折扣類型</div>
            <div class="border-r border-solid w-full text-center border-gray-200">開始時間</div>
            <div class="border-r border-solid w-full text-center border-gray-200">結束時間</div>
            <div class="border-r border-solid w-full text-center border-gray-200">專屬折扣碼</div>
            <div class="border-r border-solid w-full text-center border-gray-200">名稱</div>
            <div class="border-r border-solid w-full text-center border-gray-200">優惠方式</div>
            <div class="border-r border-solid w-full text-center border-gray-200">成交數量</div>
            <div class="border-r border-solid w-full text-center border-gray-200">成交金額</div>
            <div class="border-r border-solid w-full text-center border-gray-200">總折扣金額</div>
        </div>
        {{-- content start --}}
        <div
            class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">
            {{-- 折扣類型 --}}
            <div
                class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold whitespace-nowrap">折扣類型</div>
                    <div class=" flex flex-col justify-center items-center text-gray-350">
                        @if ($coupon->type == 'percent')
                            <span class="text-xs bg-yellow-300 rounded text-white w-10">打折</span>
                        @elseif ($coupon->type == 'discount')
                            <span class="text-xs bg-red-300 rounded text-white w-10">折抵</span>
                        @else
                            <span class="text-xs">未定義</span>

                        @endif

                    </div>
                </div>
            </div>

            {{-- 開始時間 --}}
            <div
                class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold whitespace-nowrap">開始時間</div>
                    <div class=" flex flex-col justify-center text-gray-350">
                        <span class="text-sm">{{ $coupon->start_at }}</span>
                        <span class="text-xs">{{ $coupon->start_at->diffForhumans() }}</span>
                    </div>
                </div>
            </div>
            {{-- 結束時間 --}}
            <div
                class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold whitespace-nowrap">結束時間</div>
                    <div class=" flex flex-col justify-center text-gray-350">
                        <span class="text-sm">{{ $coupon->end_at }}</span>
                        <span class="text-xs">{{ $coupon->end_at->diffForhumans() }}</span>
                    </div>
                </div>
            </div>
            {{-- 專屬折扣碼 --}}
            <div
                class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold whitespace-nowrap">專屬折扣碼</div>
                    <div class=" flex justify-center text-gray-350">
                        <span class="text-sm">{{ $coupon->code }}</span>
                    </div>
                </div>
            </div>
            {{-- 名稱與說明 --}}
            <div
                class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                <div class="flex justify-between lg:block">
                    <div class="lg:hidden font-bold whitespace-nowrap">名稱</div>
                    <div class=" flex flex-col justify-center text-gray-350">
                        <h1 class="text-xl">{{ $coupon->title }}</h1>

                        {{-- <div class="transform hover:rotate-180 h-4 hover:h-auto hover:w-auto m-1 mx-auto overflow-hidden rounded w-4">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                                <p class="transform rotate-180 px-1 text-xs whitespace-pre-line pb-5">
                                    {{ $coupon->description }}</p>
                            </div> --}}

                    </div>
                </div>
            </div>


            {{-- 優惠方式 --}}
            <div
                class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold whitespace-nowrap">優惠方式
                    </div>
                    <div class=" flex justify-center text-gray-350">
                        @if ($coupon->type == 'percent')
                            <span class="text-sm">打{{ $coupon->number * 10 }}折</span>
                        @elseif($coupon->type == 'discount')
                            <span class="text-sm">折扣NTD ${{ $coupon->number }}元</span>
                        @else
                            <span class="text-sm">未定義</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 成交數量 --}}
            <div
                class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold whitespace-nowrap">成交數量
                    </div>
                    <div class=" flex justify-center text-gray-350">
                        <span class="text-sm">{{ $coupon->Orders_Paid()->count() }}</span>
                    </div>
                </div>
            </div>
            {{-- 成交金額 --}}
            <div
                class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold whitespace-nowrap">成交金額
                    </div>
                    <div class=" flex justify-center text-gray-350">
                        <span class="text-sm">{{ $coupon->Orders_Paid()->sum('order_pay_price') }}</span>
                    </div>
                </div>
            </div>
            {{-- 總折扣金額 --}}
            <div
                class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold whitespace-nowrap">總折扣金額
                    </div>
                    <div class=" flex justify-center text-gray-350">
                        <span class="text-sm">{{ $coupon->Orders_Paid()->sum('coupon_discount') }}</span>
                    </div>
                </div>
            </div>



        </div>
        {{-- content end --}}

    </div>
    <div class="my-2 flex flex-col sm:flex-row gap-2">
        <div class="w-full sm:w-1/2  bg-white rounded shadow-sm p-5">
            <h2 class="text-xl font-bold">優惠券說明</h2>
            <p class="border-solid border-t mt-4 border-gray-100 text-gray-350 whitespace-pre-line">
                {{ $coupon->description }}</p>
        </div>
        <div class="w-full sm:w-1/2 bg-white rounded shadow-sm p-5">
            <h2 class="text-xl font-bold">優惠券限制</h2>
            <div class="mt-4 text-gray-350 ">
                低消 NTD ${{ $coupon->minimum_price }}</div>
            <div class="mt-4 text-gray-350 ">
                搭配商品「{{ $coupon->Need_Product ? $coupon->Need_Product->name : '無' }}」</div>
        </div>
    </div>


    <div v-show="draw_label.length>0" class="my-2 bg-white rounded shadow-sm p-5">
        <canvas ref="money_data" class="w-full h-full"></canvas>
        <canvas ref="times_data" class="mt-2 w-full h-full"></canvas>

    </div>

@stop

@section('JS-content')
    @parent

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"
        integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        var app = new Vue({
            el: '#app',
            data: function() {
                return {
                    orders: {!! json_encode($coupon->Orders_Paid()->get(['created_at', 'order_pay_price'])) !!},
                    times_data: {},
                    money_data: {},
                    draw_label: [],
                    draw_times_data: [],
                    draw_money_data: [],
                };
            },

            watch: {
                times_data: {
                    handler() {
                        this.makeDrawLabel()
                    },
                    deep: true
                },
                draw_label: function() {
                    this.drawTimesData();
                    this.drawMoneyData();
                },

            },
            created: function() {
                this.makeDrawData();
            },
            methods: {
                makeDrawData: function() {
                    const vm = this;
                    vm.orders.forEach((item) => {
                        item.created_at = new Date(item.created_at).toLocaleDateString()
                        if (!vm.times_data.hasOwnProperty(item.created_at)) {
                            vm.$set(vm.times_data, item.created_at, 1)
                            vm.$set(vm.money_data, item.created_at, item.order_pay_price)
                        } else {
                            vm.times_data[item.created_at] += 1;
                            vm.money_data[item.created_at] += item.order_pay_price;
                        }
                    });

                },
                makeDrawLabel: function() {
                    Date.prototype.addDays = function(days) {
                        var date = new Date(this.valueOf());
                        date.setDate(date.getDate() + days);
                        return date;
                    }
                    const vm = this;
                    const date_list = Object.keys(vm.times_data).sort((a, b) => a < b ? -1 : 1);
                    const date_list_count = date_list.length;
                    const min = new Date(date_list[0]);
                    const max = new Date(date_list[date_list_count - 1]);
                    const diffTime = Math.abs(max - min);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    for (var i = 0; i <= diffDays; i++) {
                        vm.draw_label.push(min.addDays(i).toLocaleString().split(' ')[0]);
                    }

                },
                drawMoneyData() {
                    const vm = this;
                    vm.draw_money_data = [];
                    vm.draw_label.forEach(item => {
                        vm.draw_money_data.push(vm.money_data[item] ?? 0);
                    })
                    var ctx = vm.$refs.money_data
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: vm.draw_label,
                            datasets: [{
                                label: '成交金額',
                                data: vm.draw_money_data,
                                backgroundColor: "rgba(252, 211, 77, 0.5)",
                                borderColor: "rgba(252, 211, 77, 0.5)",

                            }]
                        }
                    });
                },
                drawTimesData() {
                    const vm = this;
                    vm.draw_times_data = [];
                    vm.draw_label.forEach(item => {
                        vm.draw_times_data.push(vm.times_data[item] ?? 0);
                    })
                    var ctx = vm.$refs.times_data
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: vm.draw_label,
                            datasets: [{
                                label: '成交數量',
                                data: vm.draw_times_data,
                                //backgroundColor: "rgba(147, 197, 253, 0.5)",
                                //borderColor: "rgba(147, 197, 253, 0.5)",
                            }]
                        }
                    });
                },
                checkDeleteOrNot: function() {
                    const vm = this;


                    Swal.fire({
                        title: '是否刪除？',
                        text: "{{ $coupon->title }}",
                        showCancelButton: true,
                        confirmButtonText: '是',
                        cancelButtonText: `否`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            const dom = vm.$refs.form_delete_edit;
                            dom.querySelector('input[type=submit]').click()
                        }
                    })
                },

            }
        })
    </script>

@stop
