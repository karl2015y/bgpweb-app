
@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', 'Menu 管理')


@section('content')
<a href="{{route('MenusAddPage')}}" class="btn btn-main">新增Menu</a>
<a href="{{route('MenusEditPage', 1)}}" class="btn btn-sec">修改Menu</a>
<form action="{{route('MenusDelete', 1)}}" method="post" class="inline leading-5">
    @csrf
    @method('DElETE')
    <button class="btn btn-third">刪除Menu</button>
</form>
@stop