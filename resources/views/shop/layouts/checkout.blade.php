<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="referrer" content="always">

    <meta name="description" content="@yield('description')">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;500;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="/plugins/vue2.js"></script>
    <script src="/plugins/sweetalert2.all.min.js"></script>


</head>

<body class="flex flex-col py-5 items-center justify-start lg:justify-center lg:mt-0 mt-10">
    <script>
        let mixins = [];
    </script>
    <div id="app"
        class="w-full lg:w-7/12 lg:shadow-2xl lg:rounded-xl lg:border-solid lg:border lg:border-gray-200 lg:py-6">
        <main class="mb-8 ">
            @yield('body')
        </main>
    </div>
    <footer class=" text-brown font-semibold mt-4">
        <div class="flex gap-2 justify-center">
            <a href="#refund" v-on:click="openIframe('/refund')">退款政策</a>
            <a href="#deliver" v-on:click="openIframe('/deliver')">運送政策</a>
            <a href="#privacy-policy" v-on:click="openIframe('/privacy-policy')">隱私政策</a>
            <a href="#servicepolicy" v-on:click="openIframe('/servicepolicy')">服務條款</a>

        </div>
        <div class="text-sm text-gray-350 sm:ml-6 sm:mt-0 mt-4 text-center md:flex ">
            <div>© 2021 DEARME</div>
            <div class="border-solid md:border-l pl-2 ml-2">
                連絡電話：<a href="tel:067264458">06-7264458</a>
            </div>
            <div class="border-solid md:border-l pl-2 ml-2">
                信箱：<a href="mailto: dearmeofficialtw@gmail.com">dearmeofficialtw@gmail.com</a>
            </div>
            <div class="border-solid md:border-l pl-2 ml-2">客服時間：週一至週五 9:00AM~5:00PM</div>
        </div>


    </footer>



    @yield('JS-content')
    <script type="text/javascript">
        var app = new Vue({
            mixins: mixins,
            el: '#app',
            data: {
                header: {
                    isSticky: false,
                    showNav: true,
                },
                cartOpen: false,
                isOpen: false,
            },
            methods: {
                scroll2Top: function() {
                    window.scrollTo({
                        top: 0,
                        left: 0,
                        behavior: 'smooth'
                    });
                },
                openIframe: function(url) {
                    Swal.fire({
                        html: `<iframe class="w-full" style="height: calc(100vh - 260px);" src="${url}"></iframe>`,
                        showCancelButton: false,
                        confirmButtonText: '關閉',
                        confirmButtonColor: '#5B5B5B',
                    })
                }
            },

        })


        var app2 = new Vue({

            el: 'footer',

            methods: {
                openIframe: function(url) {
                    Swal.fire({
                        html: `<iframe class="w-full" style="height: calc(100vh - 260px);" src="${url}"></iframe>`,
                        showCancelButton: false,
                        confirmButtonText: '關閉',
                        confirmButtonColor: '#5B5B5B',
                    })
                }
            },

        })
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
