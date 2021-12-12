@extends('shop.layouts.master')

@section('body')
    <div class="container mx-auto px-6">
        @if ($category ?? false)
            <a href="{{ route('categorysPage') }}" class="text-2xl">
                <svg class="h-5 w-5 -mt-1.5 inline text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h3 class="inline text-gray-700 text-2xl font-medium">{{ $category->name }}</h3>
        @endif

        <span class="block mt-3 mt-3 sm:mt-12 text-sm text-gray-500">{{ $products->count() }} 件商品
            @if ($keyword ?? false)
                ，<a href="{{ route('productsPage') }}" class="text-blue-600">查看全部商品</a>
            @endif
        </span>
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">


            @foreach ($products as $product)
                <a href="{{ route('productPage', $product->id) }}">
                    <div class="border-gray-300 border-solid hover:shadow-xl pb-3 w-full">

                        <img wh-ratio="1" alt="ecommerce" class="object-cover object-center w-full h-full block"
                            src="{{ $product->Imgs->first()->img_url }}" />

                        <div class="mt-4 text-center">
                            <h2 class="font-bold text-gray-900">{{ $product->name }}</h2>
                            <p class="mt-1 mb-2 text-sm text-gray-350">NTD$
                                @php
                                    $p_first = $product->items->sortBy('sell_price')->first()->sell_price;
                                    $p_last = $product->items->sortBy('sell_price')->last()->sell_price;
                                @endphp
                                {{ $p_first }}
                                @if ($p_first != $p_last)
                                    ~ {{ $p_last }}
                                @endif

                            </p>
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
