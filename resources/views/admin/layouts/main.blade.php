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
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>


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
        <div
            class="bg-gray-700 sidebar text-gray-50 w-64 space-y-6 py-7 pl-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">

            <!-- logo -->
            <div class="flex">
                <div class="text-white flex items-center space-x-2 px-4">
                    <span class="text-gray-50 font-bold text-4xl text-center">BGP STudio </span>
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
            <nav class="font-bold">
                <a href="{{ route('PagesPage') }}" id="PagesPage"
                    class="block py-2 my-2 px-4 rounded-l-2xl transition duration-200 hover:bg-green-400 hover:text-white">
                    頁面管理
                </a>
                <a href="{{ route('MenusPage') }}" id="MenusPage"
                    class="block py-2 my-2 px-4 rounded-l-2xl transition duration-200 hover:bg-green-400 hover:text-white">
                    Menu管理
                </a>
                <a href="{{ route('ComponentsPage') }}" id="ComponentsPage"
                    class="hidden block py-2 my-2 px-4 rounded-l-2xl transition duration-200 hover:bg-green-400 hover:text-white">
                    元件管理
                </a>

                <a href="{{ route('admin_member.index') }}" id="admin_member.index"
                    class="block py-2 my-2 px-4 rounded-l-2xl transition duration-200 hover:bg-green-400 hover:text-white">
                    會員管理
                </a>

                <a href="{{ route('admin_product_category.index') }}" id="admin_product_category.index"
                    class="block py-2 my-2 px-4 rounded-l-2xl transition duration-200 hover:bg-green-400 hover:text-white">
                    商品管理
                </a>

                <a href="{{ route('ordersPage') }}" id="ordersPage"
                    class="block py-2 my-2 px-4 rounded-l-2xl transition duration-200 hover:bg-green-400 hover:text-white">
                    訂單管理
                </a>

                <a href="{{ route('coupon.index') }}" id="coupon.index"
                    class="block py-2 my-2 px-4 rounded-l-2xl transition duration-200 hover:bg-green-400 hover:text-white">
                    優惠碼管理
                </a>
                <a href="{{ route('contact.index') }}" id="contact.index"
                    class="block py-2 my-2 px-4 rounded-l-2xl transition duration-200 hover:bg-green-400 hover:text-white">
                    聯絡管理
                </a>
                <a href="{{ route('admin_setting.index') }}" id="admin_setting.index"
                    class="block py-2 my-2 px-4 rounded-l-2xl transition duration-200 hover:bg-green-400 hover:text-white">
                    系統設定
                </a>

                <a href="#"
                    class="block py-2.5 px-4 rounded-l-2xl transition duration-200 hover:bg-green-400 hover:text-white">
                    登出
                </a>
            </nav>
        </div>

        <!-- content -->
        <div class="flex-1 ">
            <div class="flex justify-center min-h-screen bg-gray-50 ">
                <div class="col-span-12 w-11/12 pb-10">
                    <div id="app" class="overflow-auto lg:overflow-visible pt-5 h-full">
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
        if (document.getElementById('{{ \Request::route()->getName() }}')) {
            document.getElementById('{{ \Request::route()->getName() }}').className =
                "bg-gray-50 block duration-200 hover:bg-green-400 hover:text-white px-4 py-2.5 rounded-l-2xl text-black transition"
        }
    </script>

    @if (session('message') && session('message_type') && session('message_title'))
        <script type="text/javascript">
            Swal.fire({
                icon: "{{ session('message_type') }}",
                title: "{{ session('message_title') }}",
                text: "{{ session('message') }}"
            })
        </script>
    @endif

    @if ($errors->any())
        <script type="text/javascript">
            Swal.fire({
                icon: "error",
                title: "資料錯誤",
                text: "{{ $errors->first() }}"
            })
        </script>
        </div>
    @endif
</body>

</html>
