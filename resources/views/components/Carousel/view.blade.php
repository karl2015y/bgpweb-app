@section('body')
    @parent
    @if ($pc->data)
        <section id="{{ $pc->name }}">
            <template>
                {{-- 電腦版 --}}
                @if ($pc->data->desktop_images)
                    <agile
                        class="
                    @if ($pc->data->phone_images && $pc->data->phone_wh_ratio != 0)
                    hidden sm:flex 
                    @else
                    fles
                    @endif
                    
                    mb-0 sm:mb-24 slide-{{ $pc->data->position }}-dots"
                        :nav-buttons="false" :autoplay-speed="5000" :speed="2500" fade="fade"
                        pause-on-hover="pause-on-hover" pause-on-dots-hover="pause-on-dots-hover" autoplay="autoplay">
                        {{-- <div class="slide relative">
                    <div class="absolute top-0 left-0 slide bg-black bg-opacity-25"></div>
                    <iframe frameborder="0" height="100%" width="100%"
                        src="https://youtube.com/embed/Mn4zyYVGLjU?autoplay=1&controls=0&showinfo=0&autohide=1&mute=1&loop=1&playlist=Mn4zyYVGLjU&rel=0">
                    </iframe>
                </div> --}}
                        @foreach ($pc->data->desktop_images as $di)
                            @if ($di->link == '')
                                <img wh-ratio="{{ $pc->data->desktop_wh_ratio }}" class="slide"
                                    src="{{ $di->image_url }}" />
                            @else
                                <a href="{{ $di->link }}">
                                    <img wh-ratio="{{ $pc->data->desktop_wh_ratio }}" class="slide"
                                        src="{{ $di->image_url }}" />
                                </a>
                            @endif
                        @endforeach

                    </agile>
                @endif
                @if ($pc->data->phone_images && $pc->data->phone_wh_ratio != 0)
                    {{-- 手機板 --}}
                    <agile class="flex sm:hidden slide-{{ $pc->data->position }}-dots" :nav-buttons="false"
                        :autoplay-speed="5000" :speed="2500" fade="fade" pause-on-hover="pause-on-hover"
                        pause-on-dots-hover="pause-on-dots-hover" autoplay="autoplay">
                        @foreach ($pc->data->phone_images as $di)
                            @if ($di->link == '')
                                <img wh-ratio="{{ $pc->data->phone_wh_ratio }}" class="slide"
                                    src="{{ $di->image_url }}" />
                            @else
                                <a href="{{ $di->link }}">
                                    <img wh-ratio="{{ $pc->data->phone_wh_ratio }}" class="slide"
                                        src="{{ $di->image_url }}" />
                                </a>
                            @endif
                        @endforeach
                    </agile>
                @endif


            </template>

        </section>
    @endif



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

            }

        })
    </script>
@stop
