@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '系統設定')


@section('content')





    <div class="my-2">

        {{-- title --}}
        <div
            class="hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
            <div class="border-r border-solid w-full text-center border-gray-200">設定編號</div>
            <div class="border-r border-solid w-full text-center border-gray-200">說明</div>
            <div class="border-r border-solid w-full text-center border-gray-200">值</div>
            <div class="border-r border-solid w-full text-center border-gray-200">操作</div>
        </div>
        @forelse  ($kvs as $kv)
            {{-- content start --}}
            <div
                class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">
                {{-- 設定編號 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">設定編號</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $kv->id }}</span>
                        </div>
                    </div>
                </div>



                {{-- 說明 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">說明</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $kv->text }}</span>
                        </div>
                    </div>
                </div>
                {{-- 值 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">值</div>
                        <div class=" flex justify-center text-gray-350">
                            @if ($kv->type == 'pic')
                                <img class="w-36" src="{{ $kv->value }}" alt="{{ $kv->value }}">
                            @else
                                <p class="text-sm truncate w-48">{{ $kv->value==''?'無':$kv->value }}</p>
                            @endif
                        </div>
                    </div>
                </div>



                <div
                    class="pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200 ">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="text-gray-350  w-full">
                            <a href="{{ route('admin_setting.edit', [$kv->id, $kv->type]) }}">
                                <button class="btn btn-sec btn-rwd btn-sm  text-sm">
                                    編輯
                                </button>
                            </a>
                        </div>
                    </div>


                </div>


            </div>
            {{-- content end --}}
        @empty
            <div class="border-solid border-gray-100 border rounded p-5 bg-white text-center mt-2 shadow-sm">目前沒有資料喔</div>
        @endforelse
    </div>



@stop

@section('JS-content')
    @parent




    <script>
        var app = new Vue({
            el: '#app',
            data: {},




        })
    </script>

@stop
