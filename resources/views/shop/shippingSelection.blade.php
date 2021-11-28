@extends('shop.layouts.checkout')

@section('body')
    <div class="container mx-auto px-4 lg:px-8">
        <h3 class="text-gray-700 text-2xl font-medium">選擇物流頁</h3>
        <div class="flex flex-col lg:flex-row lg:mt-8">
            <div class="w-full order-2">
                <div class="flex items-center mt-10 sm:mt-0">
                    <a href="{{ route('checkoutPage') }}" class="flex text-sm text-gray-500 focus:outline-none"><span
                            class="flex items-center justify-center border-2 border-brown  rounded-full h-5 w-5 mr-2">1</span>
                        訂購資訊</a>
                    <button class="flex text-sm text-brown ml-8 focus:outline-none"><span
                            class="flex items-center justify-center text-white bg-brown border-2 border-gray-500 rounded-full h-5 w-5 mr-2">2</span>
                        選擇物流</button>
                    <div class="flex text-sm text-gray-500 ml-8 focus:outline-none" disabled><span
                            class="flex items-center justify-center border-2 border-brown rounded-full h-5 w-5 mr-2">3</span>
                        確認並付款</div>
                </div>
                <form method="post" action="{{ route('shippingSelection') }}">
                    @csrf
                    <div class="mt-8 w-full">
                        <div>



                            <div class="bg-white">
                                <nav class="tabs flex">
                                    <button
                                        class="whitespace-nowrap tab active text-brown py-4 px-6 block hover:text-brown focus:outline-none text-brown border-b-2 font-medium border-brown">
                                        宅配物流
                                    </button>
                                    <div v-on:click.stop="openECPayShippingSelect()"
                                        class="cursor-pointer whitespace-nowrap tab text-gray-400 py-4 px-6 block hover:text-brown focus:outline-none">
                                        綠界物流(超商店到店、黑貓...)
                                    </div>
                                </nav>
                            </div>
                            <div class="mx-auto">

                                <div class="w-full">
                                    <div
                                        class="flex flex-wrap -m-2 border-solid border border-blue-50 mt-0 rounded px-4 pb-5">

                                        <div class="pt-6 p-2 w-full sm:w-1/2">
                                            <div class="relative">
                                                <label for="name" class="leading-7 text-sm text-gray-600"><span
                                                        class="text-red-400 mr-1">*</span>收件人姓名</label>
                                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="pt-6 p-2 w-full sm:w-1/2">
                                            <div class="relative">
                                                <label for="phone" class="leading-7 text-sm text-gray-600"><span
                                                        class="text-red-400 mr-1">*</span>收件人電話</label>
                                                <input type="phone" id="phone" name="phone" value="{{ old('name') }}"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="address" class="leading-7 text-sm text-gray-600"><span
                                                        class="text-red-400 mr-1">*</span>收件人地址</label>
                                                <div id="twzipcode" class="flex gap-2 mb-2">
                                                    <div data-role="county" data-style="border rounded py-1.5 px-2"
                                                        data-value="{{ old('county') }}"></div>
                                                    <div data-role="district" data-style="border rounded py-1.5 px-2"
                                                        data-value="{{ old('district') }}">
                                                    </div>
                                                    <div data-role="zipcode"
                                                        data-style="w-full sm:w-24 py-0.5 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                        data-value="{{ old('zipcode') }}"></div>
                                                </div>

                                                <input type="text" id="address" name="address"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>



                        </div>

                        <div class="flex items-center justify-between mt-8">
                            <button
                                class="flex items-center text-gray-700 text-sm font-medium rounded hover:underline focus:outline-none">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                </svg>
                                <a href="{{ route('checkoutPage') }}" class="mx-2">返回訂購資訊</a>
                            </button>


                            <button
                                class="flex items-center pl-12 pr-8 py-2 bg-brown text-white text-sm font-medium hover:bg-opacity-90 focus:outline-none focus:bg-opacity-90">
                                <span>確認並付款</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </button>


                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@stop

@section('JS-content')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-twzipcode@1.7.14/jquery.twzipcode.min.js
                                                    "></script>


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

                openConfirmWriteAgain: function() {
                    Swal.fire({
                        title: '是否再次選擇物流?',
                        text: "您已填寫過物流資料",
                        icon: 'warning',
                        html: `<div class="border rounded-md w-full px-4 py-3">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-gray-700 font-bold">物流資訊</h3>
                                            </div>
                                            <div class="flex justify-between mt-3 pt-3 border-solid border-t border-gray-300">
                                                <div class="flex">
                                                    <div class="mx-3">
                                                        <h3 class="text-sm text-gray-600">收件人姓名</h3>
                                                    </div>
                                                </div>
                                                <div><span class="font-bold">{{ $order->receiver_name }}</span></div>
                                            </div>
                                            <div class="flex justify-between mt-3 pt-3 border-solid border-t border-gray-300">
                                                <div class="flex">
                                                    <div class="mx-3">
                                                        <h3 class="text-sm text-gray-600">收件人電話</h3>
                                                    </div>
                                                </div>
                                                <div><span class="font-bold">{{ $order->receiver_phone }}</span></div>
                                            </div>
                                            <div class="flex justify-between mt-3 pt-3 border-solid border-t border-gray-300">
                                                <div class="flex">
                                                    <div class="mx-3">
                                                        <h3 class="text-sm text-gray-600">收件人地址</h3>
                                                    </div>
                                                </div>
                                                <div><span class="font-bold whitespace-nowrap">{{ $order->receiver_address }}</span></div>
                                            </div>
                                        </div>`,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '是，我要重填!',
                        cancelButtonText: '不, 我要結帳',
                        footer: ` <button
                        class="flex items-center text-gray-700 text-sm font-medium rounded hover:underline focus:outline-none">
                        <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                        </svg>
                        <a href="{{ route('checkoutPage') }}" class="mx-2">返回訂購資訊</a>
                    </button>`

                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.cancel) {
                            location.href = "{{ route('checkAndPayPage') }}"
                        }
                    })
                },

                openChooseShippingSelect: function() {
                    const vm = this;
                    Swal.fire({
                        title: '選擇想使用的物流服務',
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: '宅配物流',
                        denyButtonText: `綠界物流(超商店到店...)`,
                        confirmButtonColor: '#5B5B5B',
                        denyButtonColor: '#5D4537',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isDenied) {
                            vm.openECPayShippingSelect();
                        }
                    })
                },

                openECPayShippingSelect: function() {
                    location.href = "{{ route('LogisticsSelection') }}";
                    let timerInterval;
                    Swal.fire({
                        title: '正在開啟綠界物流!',
                        html: '請等一下喔，正在等綠界大大的回覆',
                        timer: 15000,
                        timerProgressBar: true,
                        showConfirmButton: false,

                    });


                },

            },
            created: function() {
                this.openChooseShippingSelect();
                /* 
                @if ($order->ship_type) */
                    this.openConfirmWriteAgain();
                    /* @endif */


                this.$nextTick(function() {
                    $("#twzipcode").twzipcode();

                })
                /* 
                @if (session('open_control_div')) */
                    this.editOrder = true;
                    /* @endif */
            }
        })
    </script>
    <script type="text/javascript">


    </script>

@stop
