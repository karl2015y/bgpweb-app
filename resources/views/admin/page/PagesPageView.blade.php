@extends('shop.layouts.master')

@section('title', $page->title)
@section('description', $page->description)


@foreach ($page->pageComponents->reverse() as $pc)
@include("components.{$pc->component->name}.view")
   
@endforeach
