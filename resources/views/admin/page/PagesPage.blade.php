@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '頁面管理')

@section('Breadcrumb')
    <div class="flex justify-between items-end w-full ">
        <div>
        </div>
        <div>
            <a href="{{ route('PagesAddPage') }}" class="btn btn-main btn-rwd">新增頁面</a>
        </div>

    </div>
@stop

@section('content')





    {{-- title --}}
    <div
        class="mt-2 hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
        <div class="border-r border-solid w-1/4 text-center border-gray-200">頁面標題</div>
        <div class="border-r border-solid w-1/4 text-center border-gray-200">頁面簡介</div>
        <div class="border-r border-solid w-1/4 text-center border-gray-200">自定義連結</div>
        <div class="w-1/4 text-center border-gray-200">操作</div>
    </div>
    @forelse ($pages as $page)
        {{-- content start --}}
        <div
            class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">

            <div class="lg:border-r border-solid w-full lg:w-1/4 text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold">頁面標題</div>
                    <div>{{ $page->title }}</div>
                </div>
            </div>

            <div class="lg:border-r border-solid w-full lg:w-1/4 text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold">頁面簡介</div>
                    <div>{{ $page->description }}</div>
                </div>
            </div>
            <div class="lg:border-r border-solid w-full lg:w-1/4 text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5 overflow-auto">
                    <div class="lg:hidden font-bold">自定義連結</div>
                    <div><a class="text-blue-500" href="/{{ $page->url }}" target="_blank">{{ $page->url }}</a></div>
                </div>
            </div>

            <div class="w-full lg:w-1/4 text-center border-gray-200">
                <a href="{{ route('PagesEditPage', $page->id) }}" class="btn btn-sec btn-rwd">編輯</a>
                <form action="{{ route('PagesDelete', $page->id) }}" method="post" class="inline leading-5">
                    @csrf
                    @method('DElETE')
                    <button onClick='return confirmSubmit()' class="btn btn-third btn-rwd">刪除</button>
                </form>
                <a href="{{ route('PageComponentsPage', $page->id) }}" class="btn btn-main btn-rwd">管理元件</a>

            </div>


        </div>
        {{-- content end --}}
    @empty
        <p class="text-center p-5 bg-white mt-2 rounded shadow">無資料</p>
    @endforelse
@stop

@section('JS-content')
    <script type="text/javascript">
        function confirmSubmit() {
            var agree = confirm("是否繼續?");
            if (agree) return true;
            else return false;
        }
    </script>
@stop
