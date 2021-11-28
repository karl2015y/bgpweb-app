@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '編輯品項內容')

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
            <span>※ 原價與限時特價不同時，系統將以限時價做為計算標準</span>
            <br>
            <span>※ 若原價與限時特價相同，前台將不會顯示「限時特價」</span>
            <nav class="col-span-2">
                <ol class="list-reset py-4 pl-2 rounded flex bg-grey-light text-grey">
                    <li><a href="{{ route('admin_product.show', ['admin_product' => $item->product_id]) }}"
                            class="no-underline text-blue-400">{{ $item->Product->name }}</a>
                    </li>
                    <li class="px-2">/</li>
                    <li class="text-gray-400">編輯品項內容</li>
                </ol>
            </nav>

        </div>
        <div>

            <button v-on:click="sentCreateOrNot()" class="btn btn-fourth btn-rwd">送出</button>


        </div>

    </div>
@stop

@section('content')
    <form ref="form_save_edit" action="{{ route('admin_product_item.updatePic', $item->id) }}" method="POST"
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
                <div class="h-auto w-72 mb-2 mx-auto sm:mx-0">
                    <img class="w-full h-full" src="{{ $item->img_url }}" alt="{{ $item->name }}">
                </div>

                <div class="w-72 flex justify-between gap-3 mx-auto sm:mx-0">
                    <a class="min-w-max"
                        href="{{ route('picuploadPage', ['w' => 500, 'h' => 350, 'path' => $item->img_url, 'back_url' => route('admin_product_item.editPic', $item->id)]) }}">
                        <button type="button" class="btn btn-fourth btn-rwd">裁切圖片</button>
                    </a>
                    <button v-on:click="show_reupload=true" class="btn btn-fourth btn-rwd">重新上傳圖片</button>
                </div>
            </div>






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

            mounted: function() {


            },

            methods: {

                sentCreateOrNot: function() {
                    const vm = this;
                    Swal.fire({
                        title: '是否儲存商品？',
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
