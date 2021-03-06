@php
$setting = new \App\Http\Controllers\SettingController();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="referrer" content="always">

    <meta name="description" content="@yield('description')">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="/plugins/vue2.js"></script>
    <script src="/plugins/sweetalert2.all.min.js"></script>
    {{-- <script src="https://unpkg.com/spacingjs" defer></script> --}}
    <script src="https://kit.fontawesome.com/8c0827fa7b.js" crossorigin="anonymous"></script>
    @yield('CSS-content')

    {!! $setting->get('facebook_chat') ?? '' !!}
    {!! $setting->get('GTM') ?? '' !!}

</head>

<body>
    <script>
        let mixins = [];
    </script>
    <div id="app">
        @include('shop.layouts.navbar')

        @include('shop.layouts.cart')

        <main class="h-full mb-8 ">
            @yield('body')
        </main>

        @include('shop.layouts.footer')
    </div>


    @yield('JS-content')
    <script type="text/javascript">
        var app = new Vue({
            mixins: mixins,
            el: '#app',
            data: {
                scroll_top_offset: 0,
            },
            created: function() {
                const vm = this;
                window.onresize = vm.fixImgSize;
                window.onscroll = vm.onscroll
                setTimeout(() => {
                    window.onresize()
                }, 10);

            },


            methods: {

                fixImgSize: function() {
                    setTimeout(() => {
                        document.querySelectorAll('img[wh-ratio]').forEach((el) => {
                            const ratio = el.hasAttribute("wh-ratio") ? Number(el.getAttribute(
                                'wh-ratio')) : 1;
                            el.style.height = `${el.width/ratio}px`
                        })
                        console.log('fixImgSize...done!')
                    }, 10);

                },

                onscroll: function() {
                    const vm = this;
                    vm.scroll_top_offset = window.pageYOffset;

                },

            },
        })
    </script>
    @if (session('message') && session('message_type') && session('message_title'))
        <script type="text/javascript">
            Swal.fire({
                icon: "{{ session('message_type') }}",
                title: "{{ session('message_title') }}",
                text: "{{ session('message') }}",
                footer: `<a class="text-blue-600" href="{{ route('checkoutPage') }}">?????????????????????GO GO GO</a>`

            })
        </script>
    @endif

    @if ($errors->any())
        <script type="text/javascript">
            Swal.fire({
                icon: "error",
                title: "????????????",
                text: "{{ $errors->first() }}"
            })
        </script>
        </div>
    @endif


    @if ($setting->get('ad_title') && $setting->get('ad_content') && $setting->get('ad_button') && $setting->get('ad_button_link'))
        <script type="text/javascript">
            if (new Date().getTime() > Number(localStorage.getItem("doNotShowAdAgain"))) {
                Swal.fire({
                    title: "{{ $setting->get('ad_title') }}",
                    html: `<p style="white-space: pre-line;">{{ $setting->get('ad_content') }}</p>`,
                    showCancelButton: true,
                    confirmButtonText: `{{ $setting->get('ad_button') }}`,
                    cancelButtonText: '??????????????????',

                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `{{ $setting->get('ad_button_link') }}`
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        localStorage.setItem("doNotShowAdAgain", new Date(new Date().setHours(0, 0, 0, 0) + 24 * 60 *
                            60 * 1000 - 1).getTime())
                    }
                })
            }
        </script>
    @endif

</body>

</html>
