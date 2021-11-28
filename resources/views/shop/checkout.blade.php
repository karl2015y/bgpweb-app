@extends('shop.layouts.checkout')

@section('body')
    <div class="container mx-auto px-4 lg:px-8">
        <h3 class="text-gray-700 text-2xl font-medium">結帳頁</h3>
        <div class="flex flex-col lg:flex-row lg:mt-8">
            <div class="w-full lg:w-1/2 order-2">
                <div class="flex items-center">
                    <button class="flex text-sm text-brown focus:outline-none"><span
                            class="flex items-center justify-center text-white bg-brown rounded-full h-5 w-5 mr-2">1</span>
                        訂購資訊</button>
                    <div class="flex text-sm text-gray-700 ml-8 focus:outline-none"><span
                            class="flex items-center justify-center border-2 border-blue-500 rounded-full h-5 w-5 mr-2">2</span>
                        選擇物流</div>
                    <div class="flex text-sm text-gray-500 ml-8 focus:outline-none"><span
                            class="flex items-center justify-center border-2 border-gray-500 rounded-full h-5 w-5 mr-2">3</span>
                        確認並付款</div>
                </div>
                <div class="mt-8 lg:w-3/4">
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium">優惠劵</h4>
                        {{-- 輸入前 --}}
                        @if ($order->coupon_code)
                            {{-- 輸入後 --}}
                            <div class="bg-brown flex justify-between mt-3 px-5 py-7 shadow-md w-full">


                                <div class="flex items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 12H6" />
                                    </svg>
                                    <span class="text-xs ml-1">NTD </span>
                                    <span class=" ml-1 -mt-0.5">${{ $order->coupon_discount }}</span>
                                </div>

                                <div class="flex items-center gap-2 text-gray-350">

                                    <div class="-mt-1">

                                        <svg class="h-3 w-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>

                                        <span class="text-xs">
                                            {{ $order->coupon_code }}
                                        </span>
                                    </div>



                                    <a href="{{ route('userCancelCoupon') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @else
                            <form method="post" action="{{ route('useCoupon') }}"
                                class=" flex flex-col gap-1.5 justify-between lg:w-80 w-full">
                                @csrf
                                <div class="flex bg-gray-100 p-4 w-full lg:w-80 mt-3 space-x-4 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 opacity-30" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                    </svg>
                                    <input name="coupon_code" class="bg-gray-100 outline-none" type="text"
                                        placeholder="請輸入優惠劵序號" />
                                </div>
                                <button
                                    class="text-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                    <span>套用</span>
                                </button>
                            </form>
                        @endif



                    </div>
                    <div class="mt-8">
                        <h4 class="text-sm text-gray-500 font-medium">小記</h4>
                        <div class="mt-6">
                            <div class="w-full flex justify-between">
                                <h3>商品價格</h3>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-gray-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span class="text-xs font-light">NTD</span>
                                    <span class="font-bold">${{ $order->all_product_price }}</span>
                                </div>
                            </div>
                            <div class="w-full flex justify-between">
                                <h3>優惠劵

                                </h3>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-gray-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 12H6" />
                                    </svg>
                                    <span class="text-xs font-light">NTD</span>
                                    <span class="font-bold">${{ $order->coupon_discount }}</span>
                                </div>
                            </div>

                            <div class="w-full flex justify-between">
                                <h3>運費
                                    <div class="inline-block text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 " viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </h3>
                                @if ($order->ship_type)
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span class="text-xs font-light">NTD</span>
                                        <span class="font-bold">${{ $order->ship_cost }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-600 mt-1.5">於下一步計算</span>
                                @endif
                            </div>

                            <hr class="mt-3 mb-2">
                            <div class="w-full flex justify-between">
                                <h3>總價</h3>
                                <div>
                                    <span class="text-xs font-light">NTD</span>
                                    <span class="text-xl font-bold">${{ $order->order_pay_price }}</span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-8">
                        <button
                            class="flex items-center text-gray-350 text-sm font-medium rounded hover:underline focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                            <a href="{{ route('productsPage') }}" class="mx-2">返回商城</a>
                        </button>
                        <a href="{{ route('shippingSelectionPage') }}">
                            <button
                                class="flex items-center pl-12 pr-8 py-2 bg-brown text-white text-sm font-medium hover:bg-opacity-90 focus:outline-none focus:bg-blue-500">
                                <span>選擇物流</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-full mb-8 flex-shrink-0 order-1 lg:w-1/2 lg:mb-0 lg:order-2">
                <div class="flex justify-center lg:justify-end">
                    <div class="border rounded-md max-w-md w-full px-4 py-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-700 font-medium">訂單資訊 ({{ count($order->items) }})</h3>
                            <button v-if="!editOrder" v-on:click="editOrder = !editOrder"
                                class="shadow rounded bg-gray-50 px-4 text-gray-600 hover:bg-gray-100 hover:shadow-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline -mt-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span class="text-sm">編輯</span>
                            </button>
                            <button v-else v-on:click="editOrder = !editOrder"
                                class="shadow rounded bg-gray-550 px-4 text-white hover:bg-gray-350 hover:shadow-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline -mt-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm">完成</span>
                            </button>
                        </div>
                        @forelse ($order->items as $item)
                            <div class="flex justify-between mt-3 pt-3 border-solid border-t border-gray-300">
                                <div class="flex">
                                    <div class="mx-3">
                                        <h3 class="text-sm text-gray-600">{{ $item->product_item_name }}</h3>
                                        <div class="flex items-center mt-2">
                                            <div class="text-gray-700 flex">數量：
                                                <a v-if="editOrder" class="flex items-center"
                                                    href="{{ route('lessProductItemCountFromOrder', ['order_item_id' => $item->id]) }}">
                                                    <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                                        <svg class="h-5 w-5" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                </a>
                                                {{ $item->count }}
                                                <a v-if="editOrder" class="flex items-center"
                                                    href="{{ route('addProductItemCountFromOrder', ['order_item_id' => $item->id]) }}">
                                                    <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                                        <svg class="h-5 w-5" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path
                                                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-xs font-light">NTD</span>
                                    <span class="text-xl font-bold">${{ $item->product_item_price }}</span>
                                    <button v-if="editOrder"
                                        v-on:click="removeOrderItemFromCart({{ $item->id }}, '{{ $item->product_item_name }}')"
                                        class="block ml-auto mt-1 text-red-400 focus:outline-none focus:text-gray-600">
                                        <div
                                            class="border border-solid flex items-center justify-between p-1.5 rounded-2xl shadow">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="text-sm">刪除</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="mt-4">目前無訂單資料，<a href="{{ route('productsPage') }}"
                                    class="text-blue-500">返回商城</a>去逛逛吧~</p>

                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('JS-content')
    <script type="text/javascript">
        mixins.push({

            data: function() {
                return {
                    editOrder: false,
                }

            },


            methods: {

                removeOrderItemFromCart: function(product_item_id, name = '') {
                    Swal.fire({
                        title: `是否刪除${name}`,
                        showDenyButton: true,
                        confirmButtonText: '是',
                        denyButtonText: `取消`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            document.location.href =
                                `{{ route('removeProductItemFromOrder') }}?order_item_id=${product_item_id}`;
                        } else if (result.isDenied) {
                            Swal.fire('已取消', '', 'info')
                        }
                    })

                },


            },
            created: function() {
                /* 
                @if (session('open_control_div')) */
                    this.editOrder = true;
                    /* @endif */
            }

        })
    </script>

@stop
