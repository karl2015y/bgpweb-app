@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '元件管理-新增元件類別')
@section('Breadcrumb')
    <a href="{{ route('ComponentsPage') }}" class="text-blue-600">列表</a>
    <span class="px-1">»</span>
    <span class="text-gray-400">新增</span>
@stop



@section('content')

    <form action="{{ route('ComponentsClassifyAdd') }}" method="post">
        <div class=" p-5 bg-white rounded shadow">
            @csrf
            <div>
                <label for="name" class="font-bold">
                    <span class="text-red-500">*</span>
                    元件類別名稱
                </label>
                <input placeholder="輸入元件類別的名稱" name="name" value="{{ old('name') }}"
                    class="ml-2 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full lg:w-60"
                    type="text" id="name" />
            </div>


        </div>
        <div class="mt-4 text-right">
            <button class="btn btn-main btn-rwd inline leading-5">送出</button>
            <a href="{{ route('ComponentsPage') }}" class="btn btn-fourth btn-rwd">取消</a>
        </div>
    </form>


@stop
