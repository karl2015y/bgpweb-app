@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '商品管理')

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
            {{-- <span>※ 訂單狀態「待付款」→「已付款(銀行驗證中)」→「已付款」→「揀貨中」→「已出貨」</span>
            <br>
            <span>※ 揀貨主要是告訴消費者，廠商已經確定該訂單的資訊，正在準備出貨</span> --}}
            {{-- 麵包屑 --}}
            <nav class="col-span-2">
                <ol class="list-reset py-4 pl-2 rounded flex bg-grey-light text-grey">
                    <li><a href="{{ route('admin_product_category.index') }}" class="no-underline text-blue-400">商品分類列表</a>
                    </li>
                    <li class="px-2">/</li>
                    <li class="text-gray-400">{{ $category->name }}</li>
                    <li class="px-2">/</li>
                    <li class="text-gray-400">商品列表</li>
                </ol>
            </nav>

        </div>
        <div>
            <a href="{{ route('admin_product.create', ['category_id' => $category->id]) }}">
                <button class="btn btn-fourth btn-rwd">新增商品</button>
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


    {{ $products->links() }}



    <div class="my-2">

        {{-- title --}}
        <div
            class="hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
            <div class="border-r border-solid w-full text-center border-gray-200">商品名稱</div>
            <div class="border-r border-solid w-full text-center border-gray-200">商品圖片</div>
            <div class="border-r border-solid w-full text-center border-gray-200">操作</div>
        </div>
        @forelse  ($products as $product)
            {{-- content start --}}
            <div
                class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">


                {{-- 商品名稱 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">商品名稱</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $product->name }}</span>
                        </div>
                    </div>
                </div>

                {{-- 商品圖片 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">商品圖片</div>
                        <div class=" flex justify-center text-gray-350">
                            <div class="h-auto w-40">
                                @if ($product->Imgs->first())
                                    <img class="w-full h-full" src="{{ $product->Imgs->first()->img_url }}"
                                        alt="{{ $product->name }}">
                                @else
                                    <span>無圖片</span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>


                <div
                    class="pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200 ">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="text-gray-350  w-full">
                            <a href="{{ route('admin_product.show', ['admin_product' => $product->id]) }}">
                                <button class="btn btn-main btn-rwd btn-sm  text-sm">查看商品</button>
                            </a>
                            {{-- <a href="{{ route('admin_product.edit', ['admin_product' => $product->id]) }}">
                                <button class="btn btn-sec btn-rwd btn-sm  text-sm">編輯商品</button>
                            </a>
                            <button
                                v-on:click="checkDeleteOrNot('{{ $product->name }}','{{ route('admin_product.destroy', [$product->id]) }}')"
                                class="btn btn-third btn-rwd btn-sm  text-sm">刪除商品</button> --}}



                        </div>
                    </div>


                </div>


            </div>
            {{-- content end --}}
        @empty
            <div class="border-solid border-gray-100 border rounded p-5 bg-white text-center mt-2 shadow-sm">目前沒有資料喔</div>
        @endforelse
    </div>


    {{ $products->links() }}

@stop

@section('JS-content')
    @parent




    <script>
        var app = new Vue({
            el: '#app',
            data: {},

            methods: {


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
