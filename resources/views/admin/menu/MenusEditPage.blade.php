
@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', 'Menu 管理')
@section('Breadcrumb')
    <a href="{{route('MenusPage')}}" class="text-blue-600">列表</a>
    <span class="px-1">»</span>
    <span class="text-gray-400">修改</span>
@stop



@section('content')




    <form action="{{route('MenusEdit', $menu->id)}}" method="post">
        <div class=" p-5 bg-white rounded shadow">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="font-bold">
                    <span class="text-red-500">*</span>
                    選單名稱
                </label>
                <input placeholder="輸入要在選單上顯示名稱" name="name" value="{{ old('name', $menu->name) }}"
                    class="ml-2 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full lg:w-60"
                    type="text" id="name" />
            </div>


            <div class="mt-3">
                <label for="link" class="font-bold">
                    <span class="text-red-500">*</span>
                    選單連結
                </label>
                <input placeholder="輸入點擊後要前往的連結" name="link" value="{{ old('link', $menu->link) }}"
                    class="ml-2 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full lg:w-60"
                    type="text" id="link" />
            </div>


            <div class="block lg:flex mt-3">
                <div class="mt-2 font-bold">
                    <span class="text-red-500">*</span>
                    <span>RWD顯示</span>
                </div>
                <div class="mt-1.5 ml-4 lg:ml-3 lg:mt-0">
                    <div class="flex ">
                        <label class="flex items-center">
                            <input {{ (! empty(old('desktop', $menu->show_pc)) ? 'checked' : '') }} name="desktop" type="checkbox" class="form-checkbox">
                            <span class="ml-2">顯示於桌面版 <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg></span>
                        </label>
                    </div>
                    <div class="flex mt-2">
                        <label class="flex items-center">
                            <input {{ (! empty(old('phone', $menu->show_phone)) ? 'checked' : '') }} name="phone" type="checkbox" class="form-checkbox">
                            <span class="ml-2">顯示於手機版 <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg></span>
                        </label>
                    </div>
                </div>
            </div>

        </div>
        <div class="mt-4 text-right">
            <button class="btn btn-sec btn-rwd inline leading-5">儲存Menu</button>
            <a href="{{ route('MenusPage') }}" class="btn btn-fourth btn-rwd">取消</a>
        </div>
    </form>


@stop