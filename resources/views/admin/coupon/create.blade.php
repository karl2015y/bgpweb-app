@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '新增優惠券')

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
            <span>※ 優惠券折扣碼為了準確統計數據，所以是無法做修改的</span>
            <br>
            <span>※ 若折扣類型為「打折」，打折數請輸入小數點，EX: 8折為0.8。</span>
            {{-- 麵包屑 --}}
            <nav class="col-span-2">
                <ol class="list-reset py-4 pl-2 rounded flex bg-grey-light text-grey">
                    <li><a href="{{ route('coupon.index') }}" class="no-underline text-blue-400">優惠券列表</a></li>
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
    <form ref="form_save_edit" action="{{ route('coupon.store') }}" method="POST">
        @csrf
        <input type="submit" class="hidden">
        <div class="p-4 shadow-md rounded-md text-left max-w-5xl mx-auto border-solid border border-gray-300">

            <label class="block ">
                <span class="text-gray-700">專屬折扣碼</span>
                <input name="code"
                    class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full"
                    placeholder="EX: GOOD_Coupon" value="" />
            </label>

            <label class="block mt-4">
                <span class="text-gray-700">優惠券名稱</span>
                <input name="title"
                    class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full"
                    placeholder="EX: 好優惠券" value="" />
            </label>

            <label class="block mt-4">
                <span class="text-gray-700">折扣類型</span>
                <select v-model="coupon_type" name="type"
                    class="px-2 py-1.5 rounded border-solid border border-gray-200 form-select mt-1 block w-full">
                    <option value="percent">打折</option>
                    <option value="discount">折抵現金</option>
                </select>
            </label>

            <label class="block mt-4">
                <template v-if="coupon_type=='percent'">
                    <span class="text-gray-700">打折數</span>
                    <input type="number" step="0.01" name="number"
                        class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full"
                        placeholder="打折數請輸入小數點，EX: 8折為0.8" value="" />
                </template>
                <template v-if="coupon_type=='discount'">
                    <span class="text-gray-700">折扣數</span>
                    <input type="number" step="1" min="1" name="number"
                        class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full"
                        placeholder="折扣數請輸入正整數" value="" />
                </template>
            </label>

            <v-date class="mt-4" name="start_at" text="開始時間" init_date=""></v-date>
            <v-date class="mt-4" name="end_at" text="結束時間" init_date=""></v-date>

            <label class="block mt-4">
                <span class="text-gray-700">搭配商品</span>
                <select v-model="product_id" name="product_id"
                    class="px-2 py-1.5 rounded border-solid border border-gray-200 form-select mt-1 block w-full">
                    <option value="">不限制</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="block mt-4">
                <span class="text-gray-700">最低消費金額</span>
                <input name="minimum_price"
                    class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full"
                    placeholder="888" value="0" />
            </label>

            <label class="block text-left w-full mt-4">
                <span class="text-gray-700">優惠券說明</span>
                <textarea name="description" class="form-textarea mt-1 block w-full px-3 py-2 rounded border border-solid " rows="10"
                    placeholder="詳細說明優惠券內容"></textarea>
            </label>

        </div>

    </form>
@stop

@section('JS-content')
    @parent

    @include('admin.forms.vdate')

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
                        title: '是否新增優惠券？',
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
