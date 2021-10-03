@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', 'Menu 管理')

@section('Breadcrumb')
    <div class="flex justify-between items-end w-full ">
    <div>
        <span>※順序一請選擇首頁※</span>
    </div>
    <div>
        <a href="{{ route('MenusAddPage') }}" class="btn btn-main btn-rwd">新增Menu</a>
    </div>

    </div>
@stop

@section('content')





    {{-- title --}}
    <div
        class="mt-2 hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
        <div class="border-r border-solid w-1/5 text-center border-gray-200">選單順序</div>
        <div class="border-r border-solid w-1/5 text-center border-gray-200">選單名稱</div>
        <div class="border-r border-solid w-1/5 text-center border-gray-200">選單連結</div>
        <div class="border-r border-solid w-1/5 text-center border-gray-200">RWD顯示</div>
        <div class="w-1/5 text-center border-gray-200">操作</div>
    </div>
    @foreach ($menus as $menu)
    {{-- content start --}}
    <div
        class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">
        <div class="lg:border-r border-solid w-full lg:w-1/5 text-center border-gray-200">
            <div class="flex justify-between lg:block mt-1.5">
                <div class="lg:hidden font-bold">選單順序</div>
                <div class="flex justify-center ">
                    <div>{{$menu->index}}</div>
                    <div class="text-sm pt-0.5 menu-index">
                        <form action="{{ route('MenusAdjustIndex', $menu->id) }}" method="post" class="inline leading-5">
                            @csrf
                            @method('PUT')
                            <input class="hidden" name="UpOrDown" value="Up" />
                            <button class="btn btn-sec btn-rwd" style="padding: 0.2rem;"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg></button>
                        </form>
                        <form action="{{ route('MenusAdjustIndex', $menu->id) }}" method="post" class="inline leading-5">
                            @csrf
                            @method('PUT')
                            <input class="hidden" name="UpOrDown" value="Down" />
                            <button class="btn btn-sec btn-rwd" style="padding: 0.2rem;"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:border-r border-solid w-full lg:w-1/5 text-center border-gray-200">
            <div class="flex justify-between lg:block mt-1.5">
                <div class="lg:hidden font-bold">選單名稱</div>
                <div>{{$menu->name}}</div>
            </div>
        </div>
        <div class="lg:border-r border-solid w-full lg:w-1/5 text-center border-gray-200">
            <div class="flex justify-between lg:block mt-1.5 overflow-auto">
                <div class="lg:hidden font-bold">選單連結</div>
                <div><a class="text-blue-500" href="{{$menu->link}}"
                        target="_blank">{{$menu->link}}</a></div>
            </div>
        </div>
        <div class="lg:border-r border-solid w-full lg:w-1/5 text-center border-gray-200 ">
            <div class="flex justify-between lg:block mt-1.5">
                <div class="lg:hidden font-bold">RWD顯示</div>
                <div class="flex justify-center">
                    <span><svg class="w-6 h-6 {{$menu->show_pc?'text-green-400':'text-red-400'}}" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg></span>
                    <span><svg class="w-6 h-6 {{$menu->show_phone?'text-green-400':'text-red-400'}}" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg></span>
                </div>
            </div>


        </div>
        <div class="w-full lg:w-1/5 text-center border-gray-200">
            <a href="{{ route('MenusEditPage', $menu->id) }}" class="btn btn-sec btn-rwd">修改Menu</a>
            <form action="{{ route('MenusDelete', $menu->id) }}" method="post" class="inline leading-5">
                @csrf
                @method('DElETE')
                <button onClick='return confirmSubmit()' class="btn btn-third btn-rwd">刪除Menu</button>
            </form>

        </div>
   
   
    </div>
    {{-- content end --}}
    @endforeach
@stop

@section('JS-content')
    <script type="text/javascript">
        function confirmSubmit(){
            var agree=confirm("是否繼續?");
            if (agree) return true ;
            else return false ;
        }
    </script>
@stop
