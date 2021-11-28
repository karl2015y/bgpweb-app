@section('body')
    @parent
    <div class="container px-5 py-12 mx-auto sm:px-32">
        <div class="relative mb-2 h-52">
            <img class="object-cover object-center w-full h-full block"
                src="https://images.unsplash.com/photo-1509549649946-f1b6276d4f35?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjE0NTg5fQ" />
            <a class="absolute top-0 left-0 w-full h-full" href="#2">
                <div
                    class="w-full h-full bg-black bg-opacity-40 flex flex-col justify-center items-center hover:bg-opacity-50">
                    <h1 class="text-white text-2xl font-bold text-center">最 新 新 品</h1>
                    <span class="text-gray-350 text-sm ml-5 ">瀏覽更多
                        <svg class="inline h-3 w-3 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </span>
                </div>
            </a>
        </div>
        <div class="flex gap-2 h-52">
            <div class="relative w-1/2">

                <img class="object-cover object-center w-full h-full block"
                    src="https://images.unsplash.com/photo-1509549649946-f1b6276d4f35?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjE0NTg5fQ" />
                <a class="absolute top-0 left-0 w-full h-full" href="#2">
                    <div
                        class="w-full h-full bg-black bg-opacity-40 flex flex-col justify-center items-center hover:bg-opacity-50">
                        <h1 class="text-white text-xl sm:text-2xl font-bold text-center">關 於 DEARME</h1>
                        <span class="text-gray-350 text-sm ml-5 ">瀏覽更多
                            <svg class="inline h-3 w-3 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    </div>
                </a>
            </div>
            <div class="relative w-1/2">

                <img class="object-cover object-center w-full h-full block"
                    src="https://images.unsplash.com/photo-1509549649946-f1b6276d4f35?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjE0NTg5fQ" />
                <a class="absolute top-0 left-0 w-full h-full" href="#2">
                    <div
                        class="w-full h-full bg-black bg-opacity-40 flex flex-col justify-center items-center hover:bg-opacity-50">
                        <h1 class="text-white text-2xl font-bold text-center">全 部 商 品</h1>
                        <span class="text-gray-350 text-sm ml-5 ">瀏覽更多
                            <svg class="inline h-3 w-3 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    </div>
                </a>
            </div>

        </div>

    </div>


@stop



@section('JS-content')
    @parent
    <script type="text/javascript">
        mixins.push({
            mounted: () => {
                document.querySelector('footer').remove();
                document.querySelector('header').remove();
            }

        })
    </script>
@stop
