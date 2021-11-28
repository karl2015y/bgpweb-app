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
                    <li><a href="{{ route('admin_product_type.TypeListPage',['product_id'=>$product_id]) }}" class="no-underline text-blue-400">規格管理</a>
                    </li>
                    <li class="px-2">/</li>
                    <li class="text-gray-400">編輯規格({{$productType->name}})</li>
                </ol>
            </nav>

        </div>
        <div>

            <button v-on:click="sentCreateOrNot()" class="btn btn-fourth btn-rwd">儲存</button>


        </div>

    </div>
@stop

@section('content')


    <form ref="form_save_edit" action="{{ route('admin_product_type.EditType', $productType->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="submit" class="hidden">
        <input type="text" class="hidden" value="{{ $product_id }}" name="product_id">
        <input name="options" type="text" class="hidden" :value="options_text">
        <input name="name" type="text" class="hidden" :value="name">

    </form>

    <div class="p-4 shadow-md rounded-md text-left max-w-5xl mx-auto border-solid border border-gray-300">

        <label class="block">
            <span class="text-gray-700">規格名稱</span>
            <input v-model="name" class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full"
                placeholder="EX: 大小、顏色...等等" value="" />
        </label>


        <label class="block mt-4">
            <span class="text-gray-700">規格內容</span>


            <div class="flex items-center gap-1.5">
                <input v-model="options[options.length-1]" v-on:keydown.enter="createOption()"
                    class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full sm:w-1/2"
                    placeholder="EX: 紅色、白色...等等" />

                <div v-on:click="createOption()">
                    <svg class="w-6 h-6 text-green-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <div v-for="(item, index) in options_reverses" class="flex items-center gap-1.5">
                <template v-if="index+1 < options.length">
                    <input v-model="options[index]"
                        class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full sm:w-1/2"
                        placeholder="EX: 紅色、白色...等等" />
                    <div v-on:click="options.splice(index, 1)">
                        <svg class="w-6 h-6 text-red-500 cursor-pointer" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                </template>

            </div>

        </label>


    </div>



@stop

@section('JS-content')
    @parent




    <script>
        var app = new Vue({
            el: '#app',

            data: function() {
                const options = "{{ $productType->options }}".split(', ');
                options.push('');
                return {
                    name: "{{ old('name', $productType->name) }}",
                    options: options,
                };
            },
            computed: {
                options_reverses() {
                    const options = JSON.parse(JSON.stringify(this.options));
                    options.reverse()
                    return options;
                },
                options_text() {
                    let options_text = this.options.toString();
                    if (options_text[options_text.length - 1] == ',') {
                        options_text = options_text.slice(0, -1);
                    }
                    return options_text.replaceAll(',', ', ');
                }
            },
            methods: {
                createOption: function() {
                    if (this.options[this.options.length - 1]) this.options.push('');
                },
                sentCreateOrNot: function() {
                    const vm = this;
                    Swal.fire({
                        title: '是否儲存規格？',
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
