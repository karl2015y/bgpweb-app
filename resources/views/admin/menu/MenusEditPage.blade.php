
@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', 'Menu 管理')
@section('Breadcrumb')
    <a href="{{route('MenusPage')}}" class="text-blue-600">列表</a>
    <span class="px-1">»</span>
    <span class="text-gray-400">修改</span>
@stop



@section('content')
<form action="{{route('MenusEdit', 1)}}" method="post" class="inline leading-5">
    @csrf
    @method('PUT')
    <button class="btn btn-sec">儲存Menu</button>
</form>
@stop