@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '商品管理')

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
            <span>※ 修改商品規格後，將會清除所有商品品項資訊，請千萬小心。</span>
            <br>
            <span>※ 當庫存數量為「0」時，前台將顯示補貨中。</span>
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
                    <li class="text-gray-400">{{ $product->name }}</li>
                </ol>
            </nav>

        </div>
        <div>
            <a href="{{ route('admin_product_imgs.index', ['product_id' => $product->id, 'category_id'=>$product->category_id]) }}">
                <button class="btn btn-main btn-rwd">圖片管理</button>
            </a>
            <a href="{{ route('admin_product_type.TypeListPage', ['product_id' => $product->id]) }}">
                <button class="btn btn-fourth btn-rwd">規格管理</button>
            </a>
            <a href="{{ route('admin_product.edit', ['admin_product' => $product->id]) }}">
                <button class="btn btn-sec btn-rwd">編輯商品簡介</button>
            </a>
            <button
                v-on:click="checkDeleteOrNot('{{ $product->name }}','{{ route('admin_product.destroy', [$product->id]) }}')"
                class="btn btn-third btn-rwd">刪除商品</button>

            <form ref="form_delete_edit" method="POST" action="">
                @csrf
                @method('Delete')

                <input type="submit" class="hidden">
            </form>

        </div>

    </div>
@stop

@section('content')




    @include('admin.product.productItem.index')



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
