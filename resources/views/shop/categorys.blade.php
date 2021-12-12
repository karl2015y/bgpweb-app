@extends('shop.layouts.master')

@section('body')
    <div class="container mx-auto px-6">
        <h3 class="text-gray-700 text-2xl font-medium">商品分類</h3>
        <span class="mt-3 sm:mt-12 text-sm text-gray-500">{{ $product_count }} 件商品</span>
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">

            @foreach ($categorys as $category)

                <a href="{{route('productsPage', ['category_id'=>$category->id])}}">
                    <div class="w-full max-w-sm mx-auto rounded-md shadow hover:shadow-xl overflow-hidden">
                        <div class="flex items-end justify-end h-56 w-full bg-cover"
                            style="background-image: url('{{ $category->img_url }}')">
                        </div>
                        <div class="px-5 py-3">
                            <h3 class="text-gray-700 uppercase">{{ $category->name }}</h3>
                        </div>
                    </div>

                </a>

            @endforeach

        </div>

    </div>
@stop

@section('JS-content')
    @parent

    <script type="text/javascript">

    </script>

@stop
