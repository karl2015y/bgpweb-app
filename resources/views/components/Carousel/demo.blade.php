@section('body')
    @parent
    <section id="demo">
        <template>
            {{-- 電腦版 --}}
            <agile class="hidden sm:flex mb-0 sm:mb-24 slide-right-dots" :nav-buttons="false" :autoplay-speed="5000"
                :speed="2500" fade="fade" pause-on-hover="pause-on-hover" pause-on-dots-hover="pause-on-dots-hover"
                autoplay="autoplay">
                {{-- <div class="slide relative">
                    <div class="absolute top-0 left-0 slide bg-black bg-opacity-25"></div>
                    <iframe frameborder="0" height="100%" width="100%"
                        src="https://youtube.com/embed/Mn4zyYVGLjU?autoplay=1&controls=0&showinfo=0&autohide=1&mute=1&loop=1&playlist=Mn4zyYVGLjU&rel=0">
                    </iframe>
                </div> --}}

                <a href="#1">

                    <img wh-ratio="2" class="slide" src="/images/demo1.jpg" />
                </a>
                <img wh-ratio="2" class="slide"
                    src="https://images.unsplash.com/photo-1511469054436-c7dedf24c66b?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img wh-ratio="2" class="slide"
                    src="https://images.unsplash.com/photo-1511135232973-c3ee80040060?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img wh-ratio="2" class="slide"
                    src="https://images.unsplash.com/photo-1511231683436-44735d14c11c?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img wh-ratio="2" class="slide"
                    src="https://images.unsplash.com/photo-1517677129300-07b130802f46?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
            </agile>
            {{-- 手機板 --}}
            <agile class="flex sm:hidden slide-right-dots" :nav-buttons="false" :autoplay-speed="5000" :speed="2500"
                fade="fade" pause-on-hover="pause-on-hover" pause-on-dots-hover="pause-on-dots-hover" autoplay="autoplay">
                <a href="#1">
                    <img class="slide" wh-ratio="0.685"
                        src="https://images.unsplash.com/photo-1509549649946-f1b6276d4f35?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjE0NTg5fQ" />
                </a>
                <img class="slide" wh-ratio="0.685"
                    src="https://images.unsplash.com/photo-1511469054436-c7dedf24c66b?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img class="slide" wh-ratio="0.685"
                    src="https://images.unsplash.com/photo-1511135232973-c3ee80040060?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img class="slide" wh-ratio="0.685"
                    src="https://images.unsplash.com/photo-1511231683436-44735d14c11c?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img class="slide" wh-ratio="0.685"
                    src="https://images.unsplash.com/photo-1517677129300-07b130802f46?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
            </agile>

        </template>

    </section>


@stop

@section('CSS-content')
    @parent
    <link rel="stylesheet" href="https://unpkg.com/vue-agile/dist/VueAgile.css">
    <style>
        @media (min-width: 640px) {
            .agile__dots {
                flex-direction: row !important;
            }

        }


        .slide-right-dots .agile__dots {
            bottom: .5rem;
            right: .5rem;
            position: absolute;
            gap: 0.25rem;
            flex-direction: column;
        }

        .slide-left-dots .agile__dots {
            bottom: .5rem;
            left: .5rem;
            position: absolute;
            gap: 0.25rem;
            flex-direction: column;
        }




        .agile__dot button {
            background-color: #ADADAE;
            cursor: pointer;
            display: block;
            height: .5rem;
            width: .5rem;
            font-size: 0;
            line-height: 0;
            margin: 0;
            padding: 0;
            transition-duration: 0.3s;
            border-radius: 0.25rem;
        }

        .agile__dot--current button,
        .agile__dot:hover button {
            background-color: transparent;
            border: 1px solid #ADADAE;

        }

        .slide {
            display: block;
            height: calc(100vh - 3.5rem);
            max-height: calc(100vh - 3.5rem);
            -o-object-fit: cover;
            object-fit: cover;
            width: 100%;
        }

    </style>
@stop


@section('JS-content')
    @parent
    <script src="https://unpkg.com/vue-agile"></script>
    <script type="text/javascript">
        mixins.push({
            components: {
                agile: VueAgile
            },
            mounted: () => {
                document.querySelector('footer').remove();
                document.querySelector('header').remove();
            }

        })
    </script>
@stop
