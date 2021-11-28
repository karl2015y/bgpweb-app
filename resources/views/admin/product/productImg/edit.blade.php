@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '商品圖片管理')

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
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
                    <li><a href="{{ route('admin_product_imgs.index', ['product_id' => $product->id]) }}"
                            class="no-underline text-blue-400">圖片管理</a>
                    </li>
                    <li class="px-2">/</li>
                    <li class="text-gray-400">新增圖片</li>
                </ol>
            </nav>

        </div>
        <div>
            <button v-on:click="sentCreateOrNot()" class="btn btn-main btn-rwd">儲存</button>
        </div>

    </div>
@stop

@section('content')
    <form ref="form_save_edit" action="{{ route('admin_product_imgs.update', $img->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="submit" class="hidden">
        <div class="p-4 shadow-md rounded-md text-left max-w-5xl mx-auto border-solid border border-gray-300">



            <label v-if="show_reupload" class="block ">
                <span class="text-gray-700">圖片</span>
                <input name="image" class=" py-1 form-input mt-1 block w-full" type="file"
                    accept="image/png, image/jpeg, image/gif, image/jpg" />
            </label>

            <div v-else class="">
                <span class="text-gray-700">圖片</span>
                <div class="h-auto w-72 mb-2">
                    <img class="w-full h-full" src="{{ $img->img_url }}" alt="{{ $img->name }}">
                </div>

                <div class="w-72 flex justify-between">
                    <a
                        href="{{ route('picuploadPage', ['w' => 500, 'h' => 350, 'path' => $img->img_url, 'back_url' => route('admin_product_imgs.edit',  $img->id)]) }}">
                        <button type="button" class="btn btn-fourth btn-rwd">裁切圖片</button>
                    </a>
                    <button v-on:click="show_reupload=true" class="btn btn-fourth btn-rwd">重新上傳圖片</button>
                </div>
            </div>

            <label class="block mt-4">
                <span class="text-gray-700">文字描述圖片(選填，用於SEO優化)</span>
                <input name="name" value="{{ old('name', $img->name) }}"
                    class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full"
                    placeholder="EX: 非常好用的咚咚的側面照片" value="" />
            </label>





        </div>

    </form>
@stop

@section('JS-content')
    @parent
    <script>
        var app = new Vue({
            el: '#app',
            data: function() {
                return {
                    show_reupload: false
                };
            },


            methods: {

                sentCreateOrNot: function() {
                    const vm = this;


                    Swal.fire({
                        title: '是否修改？',
                        text: "",
                        showCancelButton: true,
                        confirmButtonText: '是',
                        cancelButtonText: `否`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            const dom = vm.$refs.form_save_edit;
                            dom.querySelector('input[type=submit]').click()
                        }
                    })
                },
            }
        })
    </script>

@stop
