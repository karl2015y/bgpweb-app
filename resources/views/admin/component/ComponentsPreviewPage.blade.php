@extends('shop.layouts.master')
{{-- @extends('components.layouts.editor') --}}


@section('title', '背景模式後台-預覽元件')



@include("components.{$component->name}.demo")
