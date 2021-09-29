<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
    <title>@yield('title')</title>

</head>

<body>
    <div class="relative min-h-screen md:flex">

        <!-- mobile menu bar -->
        <div class="text-gray-600 flex md:hidden">
            <!-- mobile menu button -->
            <button class=" mobile-menu-button p-4 focus:outline-none focus:bg-gray-700">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- logo -->
            <div class="flex items-center font-bold text-2xl mx-auto pr-9">
                <span>BGP STudio </span>
            </div>
            {{-- <img class="h-14 mx-auto w-auto my-3" src="/asset/img/logo-row.png" alt=""> --}}


        </div>

        <!-- sidebar -->
        <div style="z-index: 60000;"
            class="sidebar bg-white text-gray-500 w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">

            <!-- logo -->
            <div class="flex">
                <div class="text-white flex items-center space-x-2 px-4">
                    <span class="text-black font-bold text-4xl text-center">BGP STudio </span>
                    {{-- <img class="w-full h-full" src="/asset/img/logo-row.png" alt=""> --}}
                </div>
                {{-- <a href="/admin" class="text-white flex items-center space-x-2 px-4"> --}}
                {{-- <img class="w-full h-full" src="/asset/img/logo-row.png" alt=""> --}}
                <!-- mobile menu button -->
                {{-- </a> --}}
                <button class="mobile-menu-button p-4 focus:outline-none focus:bg-gray-700 md:hidden">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>



            <!-- nav -->
            <nav>
                <a href="#"
                    id="MenusPage"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-green-400 hover:text-white">
                    Menu 管理
                </a>
                <div>
                    <span class="block bg-gray-50 py-2.5 px-4 rounded ">
                        數據總攬
                    </span>
                    <div
                        class="pl-3 bg-gray-50 hover:bg-green-400 hover:text-white">
                        <a href="#" class="block py-2.5 px-4 rounded transition duration-200">
                            點數發放列表
                        </a>
                    </div>

                    <div class="pl-3 bg-gray-50 hover:bg-green-400 hover:text-white ">
                        <a href="#" class="block py-2.5 px-4 rounded transition duration-200 ">
                            兌換券紀錄列表
                        </a>
                    </div>
                    <div class="pl-3 bg-gray-50 hover:bg-green-400 hover:text-white ">
                        <a href="#" class="block py-2.5 px-4 rounded transition duration-200">
                            民眾基本資料列表
                        </a>
                    </div>
                </div>


                <a href="#"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-green-400 hover:text-white">
                    登出
                </a>
            </nav>
        </div>

        <!-- content -->
        <div class="flex-1 ">
            <div class="flex justify-center min-h-screen bg-gray-50 ">
                <div class="col-span-12 w-11/12 pb-10">
                    <div class="overflow-auto lg:overflow-visible pt-5 h-full">
                        <div class="text-3xl font-bold">@yield('classification-name')</div>
                        <div class="pt-5 pb-3 flex items-center font-bold">
                            @yield('Breadcrumb')
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script src="{{ asset('js/app.js') }}"></script>
    @yield('JS-content')

    {{-- Menu 提醒 --}}
    <script type="text/javascript">
        if(document.getElementById('{{\Request::route()->getName()}}')){
            document.getElementById('{{\Request::route()->getName()}}').className+=' rounded bg-green-200 text-white shadow-inner'
        }
    </script>

    @if (session('message') && session('message_type') && session('message_title'))
        <script type="text/javascript">
            window.createNotification("{{ session('message_type') }}", "{{ session('message_title') }}",
                "{{ session('message') }}");
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $index => $error)
            <script type="text/javascript">
                window.createNotification('error', '新增錯誤', '{{ $error }}', '{{ $index }}');
            </script>
        @endforeach
        </div>
    @endif
</body>

</html>
