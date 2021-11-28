@extends('shop.layouts.master')

@section('title', $page->title)

@foreach ($page->pageComponents->reverse() as $pc)
@include("components.{$pc->component->name}.view")
   
@endforeach
