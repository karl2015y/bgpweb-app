@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '會員管理')


@section('content')
    {{-- 篩選器 --}}

    <form action="" method="get">
        <div class="flex items-end gap-3">
            <label class="block mt-4">
                <span class="text-gray-700">關鍵字搜尋</span>
                <input name="keyword" type="text" value="{{ $keyword }}"
                    class="px-3 py-1 rounded border-solid border border-gray-200 form-input mt-1 block w-full"
                    placeholder="" />
            </label>
            <button class="btn btn-fourth btn-sm h-10">
                <div class="mx-2">
                    <svg class="w-4 h-4 inline -mt-0.5 -mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>查詢</span>
                </div>
            </button>

        </div>
    </form>


    {{ $users->links() }}



    <div class="my-2">

        {{-- title --}}
        <div
            class="hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
            <div class="border-r border-solid w-full text-center border-gray-200">會員ID</div>
            <div class="border-r border-solid w-full text-center border-gray-200">註冊時間</div>
            <div class="border-r border-solid w-full text-center border-gray-200">會員帳號</div>
            <div class="border-r border-solid w-full text-center border-gray-200">會員IG</div>
            <div class="border-r border-solid w-full text-center border-gray-200">操作</div>
        </div>
        @forelse  ($users as $user)
            {{-- content start --}}
            <div
                class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">
                {{-- 會員ID --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">會員ID</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $user->id }}</span>
                        </div>
                    </div>
                </div>

                {{-- 註冊時間 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">註冊時間</div>
                        <div class=" flex justify-center text-gray-350 flex-col gap-2">
                            <span class="text-sm">{{ $user->created_at }}</span>
                            <span class="text-xs">({{ $user->created_at->diffForhumans() }})</span>
                        </div>
                    </div>
                </div>

                {{-- 會員IG --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">會員IG</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $user->name }}</span>
                        </div>
                    </div>
                </div>


                {{-- 會員帳號 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">會員帳號</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $user->email }}</span>
                        </div>
                    </div>
                </div>


                <div
                    class="pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200 ">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="text-gray-350  w-full">
                            <a href="{{ route('ordersPage', ['email'=> $user->email]) }}">
                                <button class="btn btn-sec btn-rwd btn-sm  text-sm">銷售紀錄</button>
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


    {{ $users->links() }}

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
