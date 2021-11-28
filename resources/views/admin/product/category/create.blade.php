@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '新增商品分類')

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
            {{-- <span>※ 優惠券折扣碼為了準確統計數據，所以是無法做修改的</span>
            <br>
            <span>※ 若折扣類型為「打折」，打折數請輸入小數點，EX: 8折為0.8。</span> --}}
            {{-- 麵包屑 --}}
            <nav class="col-span-2">
                <ol class="list-reset py-4 pl-2 rounded flex bg-grey-light text-grey">
                    <li><a href="{{ route('admin_product_category.index') }}" class="no-underline text-blue-400">商品分類列表</a>
                    </li>
                    <li class="px-2">/</li>
                    <li class="text-gray-400">新增</li>
                </ol>
            </nav>

        </div>
        <div>

            <button v-on:click="sentCreateOrNot()" class="btn btn-fourth btn-rwd">送出</button>


        </div>

    </div>
@stop

@section('content')
    <form ref="form_save_edit" action="{{ route('admin_product_category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="submit" class="hidden">
        <div class="p-4 shadow-md rounded-md text-left max-w-5xl mx-auto border-solid border border-gray-300">

            <label class="block ">
                <span class="text-gray-700">類別名稱</span>
                <input name="name" value="{{old('name')}}"
                    class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full"
                    placeholder="EX: 好吃好用好玩的" value="" />
            </label>
            <label class="block mt-4">
                <span class="text-gray-700">類別圖片(於編輯頁裁切)</span>
                <input name="image"
                    class=" py-1 form-input mt-1 block w-full" type="file"
                    accept="image/png, image/jpeg, image/gif, image/jpg" />
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
                    coupon_type: "discount",
                    product_id: ""
                };
            },


            methods: {

                sentCreateOrNot: function() {
                    const vm = this;


                    Swal.fire({
                        title: '是否新增商品分類？',
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
