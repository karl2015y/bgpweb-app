@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '商品規格管理')

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
            <span>※ 更新商品品項後，將會清除所有商品品項資訊，請千萬小心。</span>
            {{-- <span>※ 更改商品規格，將會清除所有商品品項資訊，請千萬小心。</span>
            <br>
            <span>※ 若需要關閉商品品項，請將庫存數量設定為「-1」即於前台關閉。</span> --}}
            {{-- 麵包屑 --}}
            <nav class="col-span-2">
                <ol class="list-reset py-4 pl-2 rounded flex bg-grey-light text-grey">
                    <li><a href="{{ route('admin_product_category.index') }}" class="no-underline text-blue-400">商品分類列表</a>
                    </li>
                    <li class="px-2">/</li>
                    <li><a href="{{ route('admin_product.index', ['category_id' => $product->Category->id]) }}"
                            class="no-underline text-blue-400">{{ $product->Category->name }}</a>
                    </li>
                    <li class="px-2">/</li>
                    <li><a href="{{ route('admin_product.show', ['admin_product' => $product->id]) }}"
                            class="no-underline text-blue-400">{{ $product->name }}</a>
                    </li>
                    <li class="px-2">/</li>
                    <li class="text-gray-400">規格管理</li>
                </ol>
            </nav>

        </div>
        <div>
            <a href="{{ route('admin_product_type.CreateTypePage', ['product_id' => $product->id]) }}">
                <button class="btn btn-main btn-rwd">新增規格</button>
            </a>
            <button v-on:click="checkUpdateItemOrNot()" class="btn btn-fourth btn-rwd">更新商品品項</button>

            <form ref="form_delete_edit" method="POST" action="">
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
            <div class="border-r border-solid w-full text-center border-gray-200">規格名稱</div>
            <div class="border-r border-solid w-full text-center border-gray-200">規格內容</div>
            <div class="border-r border-solid w-full text-center border-gray-200">操作</div>
        </div>
        @forelse  ($productType as $item)
            {{-- content start --}}
            <div
                class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">


                {{-- 規格名稱 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">規格名稱</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $item->name }}</span>

                        </div>
                    </div>
                </div>

                {{-- 規格內容 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">規格內容</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $item->options }}</span>

                        </div>
                    </div>
                </div>

                <div
                    class="pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200 ">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="text-gray-350  w-full">
                            <a href="{{ route('admin_product_type.EditTypePage', $item->id) }}">
                                <button class="btn btn-sec btn-rwd btn-sm  text-sm">編輯規格</button>
                            </a>
                            <button
                                v-on:click="checkDeleteOrNot('{{ $item->name }}','{{ route('admin_product_type.DeleteType', $item->id) }}')"
                                class="btn btn-third btn-rwd btn-sm  text-sm">刪除規格</button>
                        </div>
                    </div>


                </div>


            </div>
            {{-- content end --}}
        @empty
            <div class="border-solid border-gray-100 border rounded p-5 bg-white text-center mt-2 shadow-sm">目前沒有資料喔
            </div>
        @endforelse
    </div>





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
                        imageUrl: title,
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
                checkUpdateItemOrNot: function(title, url) {
                    const vm = this;
                    Swal.fire({
                        title: '更新商品品項後，將會清除所有商品品項資訊，是否繼續？',
                        // text: title,
                        showCancelButton: true,
                        confirmButtonText: '是',
                        cancelButtonText: `否`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                             location.href = "{{route('admin_product_type.UpdateItems', ['product_id'=>$product->id])}}"
                        }
                    })
                },
            }
        })
    </script>

@stop
