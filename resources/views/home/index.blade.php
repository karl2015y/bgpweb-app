@extends('shop.layouts.master')

@section('body')
    <section id="d1">
        <template>
            <agile class="mb-0 sm:mb-24 slide-right-dots" :nav-buttons="false" :autoplay-speed="5000" :speed="2500"
                fade="fade" pause-on-hover="pause-on-hover" pause-on-dots-hover="pause-on-dots-hover" autoplay="autoplay">
                {{-- <div class="slide relative">
                    <div class="absolute top-0 left-0 slide bg-black bg-opacity-25"></div>
                    <iframe frameborder="0" height="100%" width="100%"
                        src="https://youtube.com/embed/Mn4zyYVGLjU?autoplay=1&controls=0&showinfo=0&autohide=1&mute=1&loop=1&playlist=Mn4zyYVGLjU&rel=0">
                    </iframe>
                </div> --}}

                <a href="#1">

                    <img wh-ratio="1.5" class="slide"
                        src="/images/demo1.jpg" />
                </a>
                <img wh-ratio="1.5" class="slide"
                    src="https://images.unsplash.com/photo-1511469054436-c7dedf24c66b?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img wh-ratio="1.5" class="slide"
                    src="https://images.unsplash.com/photo-1511135232973-c3ee80040060?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img wh-ratio="1.5" class="slide"
                    src="https://images.unsplash.com/photo-1511231683436-44735d14c11c?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img wh-ratio="1.5" class="slide"
                    src="https://images.unsplash.com/photo-1517677129300-07b130802f46?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
            </agile>
        </template>

    </section>
    <section id="about-us">
        <template>
            <agile class="sm:flex slide-left-dots" :nav-buttons="false" :autoplay-speed="5000" :speed="2500" fade="fade"
                pause-on-hover="pause-on-hover" pause-on-dots-hover="pause-on-dots-hover" autoplay="autoplay">
                <a href="#1">
                    <img class="slide"
                        src="https://images.unsplash.com/photo-1509549649946-f1b6276d4f35?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjE0NTg5fQ" />
                </a>
                <img class="slide"
                    src="https://images.unsplash.com/photo-1511469054436-c7dedf24c66b?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img class="slide"
                    src="https://images.unsplash.com/photo-1511135232973-c3ee80040060?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img class="slide"
                    src="https://images.unsplash.com/photo-1511231683436-44735d14c11c?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
                <img class="slide"
                    src="https://images.unsplash.com/photo-1517677129300-07b130802f46?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1600&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjEyMDd9" />
            </agile>
        </template>
    </section>
    <section id="d3">
        <div class="container mx-auto px-5 my-16 py-8 sm:mt-0 sm:py-32 sm:px-32">
            {{-- 商品 --}}

            <div class="flex flex-wrap -m-4">
                @foreach ([1, 2, 3, 4] as $index)
                    @if ($loop->iteration % 2 == 1)
                        <div class="lg:w-1/4 w-1/2 p-3 pl-6 sm:pl-3">
                        @else
                            <div class="lg:w-1/4 w-1/2 p-3 pr-6 sm:pr-3">
                    @endif
                    <a class="block relative rounded overflow-hidden">
                        <img h-ratio="1" alt="ecommerce" class="object-cover object-center w-full h-full block"
                            src="https://dummyimage.com/460x460">
                    </a>
                    <div class="mt-4 text-center">
                        <h2 class="font-bold text-gray-900">穀胱甘肽膠囊</h2>
                        <p class="mt-1 mb-2 text-sm text-gray-350">NTD$ 999</p>
                        <a class="text-gray-550 font-bold text-sm" href="#">立即購買</a>
                        <hr class="w-6 mx-auto border-black mt-0.5">
                    </div>
            </div>


            @endforeach


            <div class="w-full text-center mt-12">
                <button
                    class="flex mx-auto text-white bg-gray-550 border-0 py-2 px-8 focus:outline-none hover:bg-gray-350 text-lg">Button</button>

            </div>


        </div>
        </div>
    </section>
    <section id="d4">
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

    </section>




    <section id="contact-us" class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">聯 繫 我 們</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">不論商品上或任何我們能幫上忙的地方都歡迎與我們聯絡❤</p>
            </div>
            <form method="POST" action="{{route('contact.store')}}" class="lg:w-1/2 md:w-2/3 mx-auto">
            @csrf
                <div class="flex flex-wrap -m-2">
                    <div class="p-2 w-1/2">
                        <div class="relative">
                            <label for="contact_name" class="leading-7 text-sm text-gray-600">您的姓名</label>
                            <input type="text" id="contact_name" name="contact_name" value="{{old('contact_name')}}"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                    </div>
                    <div class="p-2 w-1/2">
                        <div class="relative">
                            <label for="contact_way" class="leading-7 text-sm text-gray-600">您的Email或手機號碼</label>
                            <input type="text" id="contact_way" name="contact_way" value="{{old('contact_way')}}"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="contact_message" class="leading-7 text-sm text-gray-600">訊息</label>
                            <textarea id="contact_message" name="contact_message"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{old('contact_message')}}</textarea>
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <button
                            class="flex mx-auto text-white bg-gray-550 border-0 py-2 px-8 focus:outline-none hover:bg-gray-350 rounded text-lg">送出</button>
                    </div>
                </div>
            </form>
        </div>
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

            data: function() {
                return {
                    show_section: {
                        moving: false,
                        index: 0,
                    }
                }
            },
            watch: {
                scroll_top_offset: function(old, val) {
                    const vm = this;
                    if (!vm.isMobileDevice() && !vm.show_section.moving) {
                        setTimeout(() => {
                            let sections = document.querySelectorAll('section');
                            sections = Array.apply(null, sections);
                            sections.push(document.querySelector('footer'));
                            const section_count = sections.length;

                            if (old - val > 0) {
                                vm.show_section.index += 1;
                            } else {
                                vm.show_section.index -= 1;
                            }
                            if (vm.show_section.index >= section_count) {
                                vm.show_section.index = section_count - 1;
                            } else if (vm.show_section.index < 0) {
                                vm.show_section.index = 0;
                            }

                            vm.move2sectionByIndex(sections, vm.show_section.index);





                            console.log("move scroll", vm.show_section.index)

                        }, 10)
                    }



                }
            },
            created: function() {
                this.$nextTick(() => {
                    this.move2sectionByUrlHashTag()
                })
            },

            methods: {
                isMobileDevice: function() {
                    return (window.innerWidth <= 1024 || window.outerWidth <= 1024)
                },
                move2sectionByIndex(sections, index) {
                    const vm = this;
                    vm.show_section.moving = true
                    const target_position = sections[index].offsetTop - document
                        .querySelector('header').clientHeight;
                    window.scroll({
                        top: target_position,
                        left: 0,
                        behavior: 'smooth'
                    })
                    setTimeout(() => {
                        vm.show_section.moving = false
                    }, 850)
                },
                move2sectionByUrlHashTag() {
                    const vm = this;
                    vm.show_section.moving = true;
                    if (!vm.isMobileDevice() && window.location.hash) {
                        vm.show_section.moving = true
                        let sections = document.querySelectorAll('section');
                        sections = Array.apply(null, sections);
                        sections.push(document.querySelector('footer'));
                        setTimeout(() => {
                            const s_id = window.location.hash.replace("#", '');
                            console.log(s_id)
                            let ans_index = 0;
                            sections.some((item, index) => {
                                if (item.id == s_id) {
                                    console.log('cooches section', item.id, index)
                                    ans_index = index;
                                    return true;
                                }
                            })
                            vm.show_section.index = ans_index;
                            vm.move2sectionByIndex(sections, vm.show_section.index)

                        }, 1)
                    }


                }
            }

        })
    </script>

@stop
