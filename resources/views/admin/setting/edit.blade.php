@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '編輯系統設定')

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
            {{-- <span>※ 原價與限時特價不同時，系統將以限時價做為計算標準</span>
            <br>
            <span>※ 若原價與限時特價相同，前台將不會顯示「限時特價」</span> --}}
            <nav class="col-span-2">
                <ol class="list-reset py-4 pl-2 rounded flex bg-grey-light text-grey">
                    <li><a href="{{ route('admin_setting.index') }}"
                            class="no-underline text-blue-400">系統設定列表</a>
                    </li>
                    <li class="px-2">/</li>
                    <li class="text-gray-400">編輯「{{$kv->text}}」</li>
                </ol>
            </nav>

        </div>
        <div>

            <button v-on:click="sentCreateOrNot()" class="btn btn-fourth btn-rwd">送出</button>


        </div>

    </div>
@stop

@section('content')
    <form ref="form_save_edit" action="{{ route('admin_setting.update', $kv->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="submit" class="hidden">
        <div class="p-4 shadow-md rounded-md text-left max-w-5xl mx-auto border-solid border border-gray-300">



            <div v-if="type=='textarea'" class="block">
                <div class="text-gray-700 mb-1">值</div>
                <textarea class="form-textarea mt-1 block w-full h-64 px-3 py-2 rounded border border-solid "
                    name="value">{{ old('value', $kv->value) }}</textarea> <br>
            </div>
            <label v-else class="block ">
                <span class="text-gray-700">值</span>
                <input name="value" value="{{ old('value', $kv->value) }}" type="text"
                    class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full"
                    placeholder="" />
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
                    type: "{{$kv->type}}",
                    product_id: ""
                };
            },

            mounted: function() {


            },

            methods: {

                sentCreateOrNot: function() {
                    const vm = this;
                    Swal.fire({
                        title: '是否更改？',
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
