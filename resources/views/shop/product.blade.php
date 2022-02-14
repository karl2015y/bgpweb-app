@extends('shop.layouts.master')

@section('title', 'Dearme ' . $product->name)
{{-- @section('description', $product->description) --}}

@section('body')
    <div id="loading" v-show="!cartOpen"
        class="bg-gray-50 fixed z-20 top-0 left-0 w-full h-full flex justify-center items-center animate__animated animate__slower opacity-95">
        <lottie-player src="/js/lottie/data.json" background="transparent" speed="1.2" style="width: 300px; height: 300px;"
            loop autoplay></lottie-player>
    </div>
    <div class="container mx-auto">
        <section class="text-gray-600 body-font overflow-hidden">
            <div class="container  mx-auto">
                <div
                    class="xl:w-4/5 mx-auto flex flex-wrap lg:shadow-xl lg:border lg:border-solid lg:border-gray-300 lg:rounded lg:p-2">
                    {{-- 商品圖片 --}}
                    <div class="relative lg:w-7/12 w-full lg:h-auto">
                        {{-- 是否自動撥放 --}}
                        <div v-on:click="isAutoplay=!isAutoplay;autoPlayPics()"
                            class="absolute bg-white left-0 pb-1.5 pl-1.5 pr-2 rounded-br-xl shadow-2xl top-auto">




                            <svg v-if="isAutoplay" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>






                        </div>
                        <img wh-ratio="1.5" alt="ecommerce" class="object-cover object-center rounded w-full"
                            :src="current_pic.src">

                        <div class="flex justify-between">
                            {{-- 上一張圖片 --}}
                            <div @click.stop="nextOrLastPic('last')"
                                class="cursor-pointer absolute bg-black bg-opacity-25 cursor-pointer left-1 shadow-2xl text-white top-1/2 -mt-14 sm:-mt-16">
                                <svg class="w-6 h-6 h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </div>
                            <div class="h-32 mt-1 w-full overflow-x-hidden pb-3">
                                <div ref="ProductPics" :style="`width:${product_pics_count*25}%;min-width: 100%;`"
                                    class="flex gap-1.5 mt-2">
                                    @foreach ($product->Imgs as $img)
                                        <div @click.stop="choosePic" class="w-3/12 lg:w-2/12">
                                            <img wh-ratio="1.5" alt="{{ $img->name ? $img->name : $product->name }}"
                                                class="object-cover object-center w-full" src="{{ $img->img_url }}">
                                        </div>
                                    @endforeach
                                    @foreach ($product->items as $item)
                                        @if ($item->img_url)
                                            <div @click.stop="choosePic" class="w-3/12 lg:w-2/12">
                                                <img wh-ratio="1.5" alt="{{ $item->description }}"
                                                    name="{{ $item->name }}" class="object-cover object-center w-full"
                                                    src="{{ $item->img_url }}">
                                            </div>
                                        @endif

                                    @endforeach

                                </div>
                            </div>
                            {{-- 下一張圖片 --}}
                            <div @click.stop="nextOrLastPic('next')"
                                class="cursor-pointer absolute bg-black bg-opacity-25 cursor-pointer right-1 shadow-2xl text-white top-1/2 -mt-14 sm:-mt-16">
                                <svg class="w-6 h-6 h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    {{-- 商品資料 --}}
                    <div class="w-9/12 lg:mt-0 lg:shadow-none lg:w-4/12 mx-auto flex flex-col ">
                        <h1 class="text-center sm:text-left text-gray-550 text-3xl title-font font-medium my-10 sm:my-3">
                            {{ $product->name }}
                        </h1>

                        <div ref="product_option_div"
                            class="h-full justify-between sm:mt-12 flex flex-col w-full items-center border-b-2 border-gray-100 mb-5">
                            {{-- 品項說明 --}}
                            <div class="lg:gap-5 lg:items-start lg:text-left mb-6 text-center w-full sm:order-2"
                                v-if="choose_product_item && choose_product_item.description">
                                <h3 class="text-gray-350">品項說明</h3>
                                <div class="text-gray-550 whitespace-pre-line" v-html="choose_product_item.description">
                                </div>
                            </div>
                            <div class="w-full sm:order-3">
                                {{-- 商品品項 --}}
                                <div v-for="type in product_types" class="mb-2 flex items-center w-full">
                                    <span class="mr-3 w-3/12 ">@{{ type.name }}</span>
                                    <div class="relative w-full">
                                        <select v-on:change="chooseProductItem()"
                                            :value="choose_product_item?choose_product_item.name:''"
                                            class="appearance-none border border-gray-350 focus:outline-none pl-3 pr-10 py-2 text-base w-full">
                                            <option value="" hidden>請選擇@{{ type.name }}</option>
                                            <option v-for="option in type.options.split(', ')" :value="option">
                                                @{{ option }}</option>
                                        </select>
                                        <span
                                            class="absolute right-0 top-0 h-full w-10 text-center text-gray-350 pointer-events-none flex items-center justify-center">
                                            <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" class="w-4 h-4"
                                                viewBox="0 0 24 24">
                                                <path d="M6 9l6 6 6-6"></path>
                                            </svg>
                                        </span>
                                    </div>

                                </div>
                                {{-- 商品數量 --}}
                                <template v-if="choose_product_item">
                                    <div class="mb-3 flex items-center w-full">
                                        <div class="mr-3 w-3/12">
                                            <span>數量</span>
                                        </div>
                                        <div class="relative w-full border border-gray-350 border-solid py-2 px-2">
                                            <div class="pt-0 flex items-center gap-1 ">
                                                {{-- 減少數量 --}}
                                                <div @click.stop="plusOrMinusWannaBuyProductCount('minus')"
                                                    :class="{'text-gray-300': wanna_buy_product_data.count == 1, 'cursor-pointer': wanna_buy_product_data.count > 1}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                </div>
                                                <input v-model.number="wanna_buy_product_data.count" type="number" min="1"
                                                    :max="choose_product_item.count" placeholder="數量最少為1，最多為存量"
                                                    class="bg-white outline-none placeholder-gray-400 text-center text-sm w-full" />
                                                {{-- 增加數量 --}}
                                                <div @click.stop="plusOrMinusWannaBuyProductCount('plus')"
                                                    :class="{'text-gray-300': wanna_buy_product_data.count == choose_product_item.count, 'cursor-pointer': wanna_buy_product_data.count < choose_product_item.count}">

                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <span class="whitespace-nowrap text-sm text-gray-400">(存量：@{{ choose_product_item.count }})</span>

                                </template>

                                <div v-else class="mb-3 flex items-center w-full">
                                    <div class="mr-3 w-3/12">
                                        <span>數量</span><br>
                                    </div>
                                    <div class="relative w-full border border-gray-350 border-solid py-2 px-2">
                                        <div class="pt-0 flex items-center gap-1 ">
                                            {{-- 減少數量 --}}
                                            <div class="text-gray-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 12H4"></path>
                                                </svg>
                                            </div>
                                            <input type="number" min="1" disabled value="1" placeholder="數量最少為1，最多為存量"
                                                class="bg-white outline-none placeholder-gray-400 text-center text-sm w-full" />
                                            {{-- 增加數量 --}}
                                            <div class="text-gray-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- 價錢 --}}
                            <div v-if="choose_product_item" class="text-center w-full sm:text-left mt-5 sm:order-1">


                                <span v-if="choose_product_item.count==0"
                                    class="font-bold block title-font font-medium text-2xl text-red-600">已售罄，補貨中‧</span>

                                <template v-else-if="choose_product_item.org_price!=choose_product_item.sell_price">
                                    <span class="font-bold block title-font font-medium text-2xl text-red-600">限時特價：NTD
                                        @{{ choose_product_item.sell_price }}</span>
                                    <span class="line-through title-font font-medium text-sm text-gray-350">原價：NTD
                                        @{{ choose_product_item.org_price }}</span>
                                </template>
                                <span v-else class="font-bold block title-font font-medium text-2xl text-gray-900">建議售價：NTD
                                    @{{ choose_product_item.sell_price }}</span>

                            </div>

                            <form v-if="choose_product_item && choose_product_item.count>0" class="sm:order-4"
                                action="{{ route('addProductItemToOrder') }}" method="get">
                                <input name="item_id" type="hidden" v-model="wanna_buy_product_data.item_id">
                                <input name="count" type="hidden" v-model="wanna_buy_product_data.count">
                                <button :disabled="!wanna_buy_product_data.item_id"
                                    class="bg-gray-550 border-0 flex focus:outline-none justify-center mt-4 mx-auto px-20 py-2 text-white w-full">
                                    加入購物車
                                </button>
                            </form>
                            <button v-else disabled
                                class="sm:order-4 bg-gray-550 border-0 flex focus:outline-none justify-center mt-4 mx-auto px-20 py-2 text-white w-full">
                                加入購物車
                            </button>


                        </div>
                    </div>


                </div>
        </section>
        <div class="mt-5 xl:w-4/5 mx-auto m">
            <div class="p-dscp py-3 rounded border-t border-b border-gray-300 border-solid lg:border lg:shadow-xl">
                {!! $product->description !!}
            </div>
        </div>
        {{-- <div class="mx-6 mt-16">
            <h3 class="text-gray-600 text-2xl font-medium">More Products</h3>
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">
                <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden">
                    <div class="flex items-end justify-end h-56 w-full bg-cover"
                        style="background-image: url('https://images.unsplash.com/photo-1563170351-be82bc888aa4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=376&q=80')">
                        <button
                            class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="px-5 py-3">
                        <h3 class="text-gray-700 uppercase">Chanel</h3>
                        <span class="text-gray-500 mt-2">$12</span>
                    </div>
                </div>
                <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden">
                    <div class="flex items-end justify-end h-56 w-full bg-cover"
                        style="background-image: url('https://images.unsplash.com/photo-1544441893-675973e31985?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80')">
                        <button
                            class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="px-5 py-3">
                        <h3 class="text-gray-700 uppercase">Man Mix</h3>
                        <span class="text-gray-500 mt-2">$12</span>
                    </div>
                </div>
                <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden">
                    <div class="flex items-end justify-end h-56 w-full bg-cover"
                        style="background-image: url('https://images.unsplash.com/photo-1532667449560-72a95c8d381b?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80')">
                        <button
                            class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="px-5 py-3">
                        <h3 class="text-gray-700 uppercase">Classic watch</h3>
                        <span class="text-gray-500 mt-2">$12</span>
                    </div>
                </div>
                <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden">
                    <div class="flex items-end justify-end h-56 w-full bg-cover"
                        style="background-image: url('https://images.unsplash.com/photo-1590664863685-a99ef05e9f61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=345&q=80')">
                        <button
                            class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="px-5 py-3">
                        <h3 class="text-gray-700 uppercase">woman mix</h3>
                        <span class="text-gray-500 mt-2">$12</span>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@stop



@section('CSS-content')
    @parent
    <style>
        .p-dscp iframe {
            width: 100%;
            height: calc(90vw*0.5625);
        }

    </style>
@stop


@section('JS-content')
    @parent
    <script src="/js/lottie/lottie-player.js"></script>

    <script type="text/javascript">
        mixins.push({

            data: function() {
                return {
                    // 圖片
                    current_pic: {
                        src: 'https://dummyimage.com/750x750',
                        dom: null,
                        index: 0,
                        interval: null
                    },
                    product_pics_count: 8,
                    isAutoplay: true,
                    // 商品品項
                    product_types: {!! json_encode($product->types) !!},
                    product_items: {!! json_encode($product->items) !!},
                    // 選到的product item
                    choose_product_item: null,
                    // 要加入購物車的商品
                    wanna_buy_product_data: {
                        item_id: null,
                        count: 1,
                    }
                }
            },

            created: function() {
                const vm = this;
                //輪播速度
                vm.autoPlayPics()
            },
            mounted: function() {
                const vm = this;
                setTimeout(() => {
                    vm.product_pics_count = vm.$refs.ProductPics.children.length;
                    vm.choosePic(vm.$refs.ProductPics.firstElementChild)
                    // vm.chooseProductItem()
                }, 10);

                if (this.cartOpen) {
                    document.querySelector("#loading").remove();
                } else {
                    setTimeout(() => {
                        document.querySelector("#loading").classList.add("animate__fadeOut");
                    }, 2000)
                    setTimeout(() => {
                        document.querySelector("#loading").remove();
                    }, 3500)
                }



            },
            methods: {

                choosePic: function(el) {
                    const vm = this;

                    if (vm.current_pic.dom) {
                        vm.current_pic.dom.classList.remove("border-solid", "border-4", "rounded", "-mt-0.5");
                    }

                    let pic_dom = null
                    let pics_scroll_div_dom = null

                    if (el.target && el.target.src) {
                        vm.current_pic.dom = el.target.parentElement
                        vm.current_pic.src = el.target.src
                        pic_dom = el.target
                        pics_scroll_div_dom = pic_dom.parentElement.parentElement.parentElement


                        vm.current_pic.index = Array.from(vm.current_pic.dom.parentNode.children).indexOf(vm
                            .current_pic.dom)



                    } else if (el.firstElementChild && el.firstElementChild.src) {
                        pic_dom = el.firstElementChild
                        vm.current_pic.dom = pic_dom
                        vm.current_pic.src = el.firstElementChild.src
                        pics_scroll_div_dom = pic_dom.parentElement.parentElement.parentElement

                    }



                    pics_scroll_div_dom.scrollTo({
                        top: 0,
                        left: pic_dom.offsetLeft - pic_dom.width * 2,
                        behavior: 'smooth'
                    })
                    vm.current_pic.dom.classList.add("border-solid", "border-4", "rounded", "-mt-0.5");


                },
                nextOrLastPic: function(type = 'next') {
                    const vm = this;
                    if (type == 'last' && vm.current_pic.index != 0) {
                        vm.current_pic.index -= 1
                    } else if (type == 'next') {
                        vm.current_pic.index += 1
                    }
                    vm.choosePic(vm.$refs.ProductPics.children[vm.current_pic.index % vm
                        .product_pics_count])

                    vm.autoPlayPics()


                },
                autoPlayPics: function() {
                    const vm = this;
                    if (vm.current_pic.interval) {
                        clearInterval(vm.current_pic.interval);
                        vm.current_pic.interval = null
                    }
                    if (vm.isAutoplay) {
                        vm.current_pic.interval = setInterval(() => {
                            vm.current_pic.index += 1;
                            vm.choosePic(vm.$refs.ProductPics.children[vm.current_pic.index % vm
                                .product_pics_count])
                        }, 6000)
                    }
                },
                chooseProductItem: function() {
                    const vm = this;
                    let chooseItemKey = ""
                    vm.$refs.product_option_div.querySelectorAll("select").forEach((item) => {
                        chooseItemKey += item.value
                    })
                    console.log(chooseItemKey)


                    let chooseItemPicDom = vm.$refs.ProductPics.querySelector(`img[name=${chooseItemKey}]`);

                    if (chooseItemPicDom) {
                        vm.isAutoplay = false;
                        vm.autoPlayPics();
                        chooseItemPicDom = chooseItemPicDom.parentElement;
                        vm.choosePic(chooseItemPicDom);
                        vm.current_pic.index = Array.from(vm.current_pic.dom.parentNode.parentNode.children)
                            .indexOf(vm
                                .current_pic.dom.parentNode)
                    } else {
                        vm.isAutoplay = true;
                        vm.autoPlayPics();
                    }

                    if (vm.product_items.find(item => item.name === chooseItemKey)) {
                        vm.choose_product_item = JSON.parse(JSON.stringify(vm.product_items.find(item => item
                            .name ===
                            chooseItemKey)))
                        vm.wanna_buy_product_data.item_id = vm.choose_product_item.id;
                    }

                },
                plusOrMinusWannaBuyProductCount: function(type = 'plus') {
                    const vm = this;
                    if (type == 'plus' && vm.wanna_buy_product_data.count < vm.choose_product_item.count) {
                        vm.wanna_buy_product_data.count += 1;
                    } else if (type == 'minus' && vm.wanna_buy_product_data.count > 1) {
                        vm.wanna_buy_product_data.count -= 1;
                    } else {
                        return;
                    }
                }

            }

        })
    </script>

@stop
