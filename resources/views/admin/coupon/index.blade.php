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
                    {{-- <li><a href="{{ route('ordersPage') }}" class="no-underline text-blue-400">訂單列表</a></li>
                    <li class="px-2">/</li> --}}
                    <li class="text-gray-400">優惠券列表</li>
                </ol>
            </nav>

        </div>
        <div>
            <a href="{{ route('coupon.create') }}">
                <button v-if="filter_target!='Owner'" class="btn btn-fourth btn-rwd">新增優惠券</button>
            </a>
            <form ref="form_delete_edit" method="POST" action="">
                @csrf
                @method('Delete')

                <input type="submit" class="hidden">
            </form>

        </div>

    </div>
@stop

@section('content')
    {{-- 篩選器 --}}

    <form action="" method="get">
        <input class="hidden" id="changeTableStatus" type="submit" value="">
        <input class="hidden" v-model="filter_target" type="text" name="filter">
        <div v-on:click="clickFliter()" class="flex text-sm overflow-x-auto sm:ml-0 mb-3 sm:mb-0">
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


    {{ $coupons->links() }}



    <div class="my-2">

        {{-- title --}}
        <div
            class="hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
            <div class="border-r border-solid w-full text-center border-gray-200">折扣類型</div>
            <div class="border-r border-solid w-full text-center border-gray-200">開始時間</div>
            <div class="border-r border-solid w-full text-center border-gray-200">結束時間</div>
            <div class="border-r border-solid w-full text-center border-gray-200">專屬折扣碼</div>
            <div class="border-r border-solid w-full text-center border-gray-200">名稱與說明</div>
            <div class="border-r border-solid w-full text-center border-gray-200">優惠方式</div>
            <div class="border-r border-solid w-full text-center border-gray-200">成交數量</div>
            <div class="border-r border-solid w-full text-center border-gray-200">成交金額</div>
            <div class="border-r border-solid w-full text-center border-gray-200">總折扣金額</div>
            <div v-if="filter_target!='Delete'" class="border-r border-solid w-full text-center border-gray-200">操作</div>
        </div>
        @forelse  ($coupons as $coupon)
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
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $coupon->start_at->diffForhumans() }}</span>
                        </div>
                    </div>
                </div>
                {{-- 結束時間 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">結束時間</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $coupon->end_at->diffForhumans() }}</span>
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
                                <span class="text-sm">扣{{ $coupon->number }}折</span>
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
                <div v-if="filter_target!='Delete'"
                    class="pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200 ">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="text-gray-350  w-full">
                            <a href="{{ route('coupon.show', ['coupon' => $coupon->id]) }}">
                                <button class="btn btn-sec btn-rwd btn-sm  text-sm">查看</button>
                            </a>

                            <button
                                v-on:click="checkDeleteOrNot('{{ $coupon->title }}','{{ route('coupon.destroy', [$coupon->id]) }}')"
                                class="btn btn-third btn-rwd btn-sm  text-sm">刪除</button>



                        </div>
                    </div>


                </div>


            </div>
            {{-- content end --}}
        @empty
            <div class="border-solid border-gray-100 border rounded p-5 bg-white text-center mt-2 shadow-sm">目前沒有資料喔</div>
        @endforelse
    </div>


    {{ $coupons->links() }}

@stop

@section('JS-content')
    @parent




    <script>
        var app = new Vue({
            el: '#app',
            data: {
                filter_target: 'Now',
                filter_option: [{
                        val: 'Now',
                        text: '通行中',
                    }, {
                        val: 'Before',
                        text: '已過期',
                    },
                    {
                        val: 'After',
                        text: '尚未開放',
                    }, {
                        val: 'Delete',
                        text: '刪除',
                    },

                ],



                selectOrderIds: {}
            },

            computed: {
                selectOrderIdCount() {
                    return Object.entries(this.selectOrderIds).filter(item => item[1])
                },

            },

            created: function() {
                this.filter_target = this.getUrlQuery('filter') ? this.getUrlQuery('filter') : 'Now';
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
                checkDeleteOrNot: function(title, delete_url) {
                    const vm = this;


                    Swal.fire({
                        title: '是否刪除？',
                        text: title,
                        showCancelButton: true,
                        confirmButtonText: '是',
                        cancelButtonText: `否`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            const dom = vm.$refs.form_delete_edit;
                            dom.action = delete_url;
                            dom.querySelector('input[type=submit]').click()
                        }
                    })
                },
            }
        })
    </script>

@stop
