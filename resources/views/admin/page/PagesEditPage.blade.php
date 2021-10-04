@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '頁面管理')
@section('Breadcrumb')
    <a href="{{ route('PagesPage') }}" class="text-blue-600">列表</a>
    <span class="px-1">»</span>
    <span class="text-gray-400">新增</span>
@stop



@section('content')

    <form action="{{ route('PagesEdit', $page->id) }}" method="post">
        <div class=" p-5 bg-white rounded shadow">
            @csrf
            @method('PUT')
            <div>
                <label for="title" class="font-bold">
                    <span class="text-red-500">*</span>
                    頁面標題
                </label>
                <input placeholder="輸入該頁面上方與Google上顯示的名稱" name="title" value="{{ old('title', $page->title) }}"
                    class="ml-2 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full lg:w-80"
                    type="text" id="title" />
            </div>


            <div class="mt-3 block lg:flex">
                <label for="description" class="font-bold">
                    <span class="text-red-500">*</span>
                    頁面簡介
                </label>

                <textarea id="description" class="ml-2 lg:ml-3 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full lg:w-80" name="description" placeholder="輸入對於該頁面的簡介(對SEO有影響)" rows="6"
                    cols="40">{{ old('description', $page->description) }}</textarea>
            </div>

            <div class="mt-3">
                <label for="url" class="font-bold">
                    <span class="text-red-500">*</span>
                    自定義連結
                </label>
                <input placeholder="輸入該頁面專屬的連結" name="url" value="{{ old('url', $page->url) }}"
                    class="ml-2 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full lg:w-80"
                    type="text" id="url" />
            </div>


        </div>
        <div class="mt-4 text-right">
            <button class="btn btn-main btn-rwd inline leading-5">送出</button>
            <a href="{{ route('PagesPage') }}" class="btn btn-fourth btn-rwd">取消</a>
        </div>
    </form>


@stop
