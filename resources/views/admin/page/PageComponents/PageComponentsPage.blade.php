@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', $page->title)

@section('Breadcrumb')
    <a href="{{ route('PagesPage') }}" class="text-blue-600">頁面列表</a>
    <span class="px-1">»</span>
    <span class="text-gray-400">元件列表</span>
@stop

@section('content')
    <div class="flex justify-between items-end w-full ">
        <div>
        </div>
        <div>
            <a href="{{ route('PagesPageView', $page->url) }}" class="btn btn-fourth btn-rwd">預覽</a>
            <a href="{{ route('PageComponentsAddPage', $page->id) }}" class="btn btn-main btn-rwd">新增元件</a>
        </div>
    </div>

    {{-- title --}}
    <div
        class="mt-2 hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
        <div class="border-r border-solid w-1/4 text-center border-gray-200">元件順序</div>
        <div class="border-r border-solid w-1/4 text-center border-gray-200">元件名稱</div>
        <div class="border-r border-solid w-1/4 text-center border-gray-200">元件id</div>
        <div class="w-1/4 text-center border-gray-200">操作</div>
    </div>
    @forelse ($components as $component)
        {{-- content start --}}



        <div
            class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">
            
            
            
            <div class="lg:border-r border-solid w-full lg:w-1/4 text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold">元件順序</div>
                    <div class="flex justify-center ">
                        <div>{{ $component->index}}</div>
                        <div class="text-sm pt-0.5 menu-index">
                            <form action="{{ route('PageComponentsAdjustIndex', ['pages_id'=>$page->id,'page_components_id'=>$component->id]) }}" method="post" class="inline leading-5">
                                @csrf
                                @method('PUT')
                                <input class="hidden" name="UpOrDown" value="Up" />
                                <button class="btn btn-sec btn-rwd" style="padding: 0.2rem;"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg></button>
                            </form>
                            <form action="{{ route('PageComponentsAdjustIndex', ['pages_id'=>$page->id,'page_components_id'=>$component->id]) }}" method="post" class="inline leading-5">
                                @csrf
                                @method('PUT')
                                <input class="hidden" name="UpOrDown" value="Down" />
                                <button class="btn btn-sec btn-rwd" style="padding: 0.2rem;"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:border-r border-solid w-full lg:w-1/4 text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold">元件名稱</div>
                    <div>{{ $component->component->show_name }}</div>
                </div>
            </div>
            <div class="lg:border-r border-solid w-full lg:w-1/4 text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold">元件id</div>
                    <div>{{ $component->name }}</div>
                </div>
            </div>


            <div class="w-full lg:w-1/4 text-center border-gray-200">
                <a href="{{ route('PageComponentsEditPage',  ['pages_id'=>$page->id,'page_components_id'=>$component->id]) }}" class="btn btn-sec btn-rwd">編輯</a>
                <form action="{{ route('PageComponentsDelete',   ['pages_id'=>$page->id,'page_components_id'=>$component->id] ) }}" method="post" class="inline leading-5">
                    @csrf
                    @method('DElETE')
                    <button onClick='return confirmSubmit()' class="btn btn-third btn-rwd">刪除</button>
                </form>

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
