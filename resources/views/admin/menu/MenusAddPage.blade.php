
@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', 'Menu 管理')
@section('Breadcrumb')
      <a href="{{route('MenusPage')}}" class="text-blue-600">列表</a>
    <span class="px-1">»</span>
    <span class="text-gray-400">新增</span>
@stop



@section('content')
<form action="{{route('MenusAdd')}}" method="post" class="inline leading-5">
    @csrf
    <button class="btn btn-main">新增Menu</button>
</form>
@stop