@extends('shop.layouts.checkout')

@section('body')

    @if (count($order->items) == 0)
        <p class="mt-4 text-center">訂單資料已過期，<a href="{{ route('productsPage') }}" class="text-brown">返回商城</a>去逛逛吧~</p>
    @else

        <div class="container mx-auto px-4 lg:px-8">

            <h3 class="text-gray-700 text-2xl font-medium">結帳頁</h3>
            <form class="flex flex-col lg:flex-row lg:mt-8" action="{{ route('payPage') }}" method="post">
                @csrf
                <div class="w-full lg:w-1/2 ">

                    <div class="flex items-center mt-10 sm:mt-0">
                        <button class="flex text-sm text-gray-500 focus:outline-none"><span
                                class="flex items-center justify-center  rounded-full h-5 w-5 mr-2">1</span>
                            訂購資訊</button>
                        <button class="flex text-sm text-gray-500 ml-8 focus:outline-none"><span
                                class="flex items-center justify-center border-2 border-brown rounded-full h-5 w-5 mr-2">2</span>
                            選擇物流</button>
                        <button class="flex text-sm text-brown ml-8 focus:outline-none"><span
                                class="flex items-center justify-center text-white  border-2  bg-brown border-gray-500 rounded-full h-5 w-5 mr-2">3</span>
                            確認並付款</button>
                    </div>

                    <div class="mt-8 lg:w-3/4">
                        <div>
                            @if ($order->coupon_code)
                                <h4 class="text-sm text-gray-500 font-medium">優惠劵</h4>
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

                                </div>
                            </div>


                            @endif



                        </div>
                        <div class="mt-8">
                            <h4 class="text-sm text-gray-500 font-medium">小記</h4>
                            <div class="mt-6">
                                <div class="w-full flex justify-between">
                                    <h3>商品價格</h3>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 "
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </h3>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span class="text-xs font-light">NTD</span>
                                        <span class="font-bold">${{ $order->ship_cost }}</span>
                                    </div>
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


                        <div class="hidden lg:flex items-center justify-between mt-8">
                            <button
                                class="flex items-center text-gray-700 text-sm font-medium rounded hover:underline focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7">
                                    </path>
                                </svg>
                                <a href="{{ route('shippingSelectionPage') }}" class="mx-2">重新選擇物流</a>
                            </button>
                            <a class="block lg:hidden" href="{{ route('payPage') }}">
                                <button
                                    class="flex items-center pl-12 pr-8 py-2 bg-brown text-white text-sm font-medium hover:bg-opacity-90 focus:outline-none focus:bg-opacity-90">
                                    <span>建立1訂單</span>
                                    <svg class="h-5 w-5 mx-2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>


                </div>
                <div class="w-full mb-8 flex-shrink-0 order-1 lg:w-1/2 lg:mb-0">
                    {{-- 訂單資訊 --}}
                    <div
                        class="border-solid border-l border-gray-350  lg:border-0 lg:ml-0 flex justify-center lg:justify-end">
                        <div class="border rounded-md w-full px-4 py-3">
                            <div class="flex items-center justify-between">
                                <h3 class="text-gray-700 font-bold">訂單資訊 ({{ count($order->items) }})</h3>
                            </div>
                            @forelse ($order->items as $item)
                                <div class="flex justify-between mt-3 pt-3 border-solid border-t border-gray-300">
                                    <div class="flex">
                                        <div class="mx-3">
                                            <h3 class="text-sm text-gray-600">{{ $item->product_item_name }}</h3>
                                            <div class="flex items-center mt-2">
                                                <div class="text-gray-700 flex">數量：

                                                    {{ $item->count }}

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-xs font-light">NTD</span>
                                        <span class="text-xl font-bold">${{ $item->product_item_price }}</span>

                                    </div>
                                </div>
                            @empty
                                <p class="mt-4">訂單資料已過期，<a href="{{ route('productsPage') }}"
                                        class="text-brown">返回商城</a>去逛逛吧~</p>

                            @endforelse

                        </div>
                    </div>
                    {{-- 物流資訊 --}}
                    <div
                        class="border-solid border-l border-gray-350  lg:border-0 lg:ml-0 flex justify-center lg:justify-end">
                        <div class="border rounded-md w-full px-4 py-3">
                            <div class="flex items-center justify-between">
                                <h3 class="text-gray-700 font-bold">物流資訊</h3>
                            </div>
                            {{-- 收件人姓名 --}}
                            <div class="flex justify-between mt-3 pt-3 border-solid border-t border-gray-300">
                                <div class="flex">
                                    <div class="mx-3">
                                        <h3 class="text-sm text-gray-600">收件人姓名</h3>
                                    </div>
                                </div>
                                <div>
                                    <span class="font-bold">{{ $order->receiver_name }}</span>
                                    {{-- <span class="text-xs font-light">帥哥/美女</span> --}}

                                </div>
                            </div>
                            {{-- 收件人電話 --}}
                            <div class="flex justify-between mt-3 pt-3 border-solid border-t border-gray-300">
                                <div class="flex">
                                    <div class="mx-3">
                                        <h3 class="text-sm text-gray-600">收件人電話</h3>
                                    </div>
                                </div>
                                <div>
                                    <span class="font-bold">{{ $order->receiver_phone }}</span>
                                    {{-- <span class="text-xs font-light">帥哥/美女</span> --}}

                                </div>
                            </div>
                            {{-- 收件人地址 --}}
                            <div class="flex justify-between mt-3 pt-3 border-solid border-t border-gray-300">
                                <div class="flex">
                                    <div class="mx-3">
                                        <h3 class="text-sm text-gray-600">收件人地址</h3>
                                    </div>
                                </div>
                                <div>
                                    <span class="font-bold whitespace-nowrap">{{ $order->receiver_address }}</span>
                                    {{-- <span class="text-xs font-light">帥哥/美女</span> --}}

                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="p-2 w-full">
                        {{-- 訂單通知 Email --}}
                        <div class="relative">
                            <label for="email" class="leading-7 text-sm text-gray-600">訂單通知 Email<span
                                    class="text-red-400 ml-1">*</span></label>
                            <input type="text" id="email" name="email" value="{{ old('email') }}"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        {{-- 訂單備註 --}}
                        <div class="w-full">
                            <div class="relative">
                                <label for="message" class="leading-6 text-sm text-gray-600">訂單備註</label>
                                <textarea v-html="'{!! $order->receiver_note !!}'" id="message" name="message"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-20 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="lg:justify-around flex items-center justify-between mt-8">
                        <button
                            class="flex lg:hidden items-center text-gray-700 text-sm font-medium rounded hover:underline focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                            <a href="{{ route('shippingSelectionPage') }}" class="mx-2 whitespace-nowrap">重新選擇物流</a>
                        </button>
                        <a class="w-full" href="{{ route('payPage') }}">
                            <button
                                class="ml-auto mr-3 w-2/3 sm:w-full flex items-center justify-center text-center py-2 bg-brown text-white text-sm font-medium hover:bg-opacity-90 focus:outline-none focus:bg-opacity-90">
                                <span class="ml-4 sm:ml-6">建立訂單</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </button>
                        </a>
                    </div>
                </div>
            </form>
        </div>

    @endif





@stop

@section('JS-content')
    <script type="text/javascript">
        mixins.push({

            data: function() {
                return {}

            },


            methods: {




            },
            created: function() {

            }

        })
    </script>

@stop
