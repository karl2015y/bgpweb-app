@php
$menus = ('App\Models\Menu')::orderBy('index')->get();
@endphp

<header ref="header" class="z-20 bg-white" :class="{'shadow-2xl fixed top-0 w-full':header.isSticky}">
    <div class="mx-8 sm:mx-12 py-3 sm:py-9">
        <div class="flex items-center justify-between">
            <div class="flex sm:hidden w-full gap-2">
                {{-- 手機板 Menu開啟按鈕 --}}
                <button v-on:click="isMenuOpen = !isMenuOpen" type="button"
                    class="text-gray-350 hover:text-gray-500 focus:outline-none focus:text-gray-500"
                    aria-label="toggle menu">
                    <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                        <path fill-rule="evenodd"
                            d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z">
                        </path>
                    </svg>
                </button>

                {{-- 手機板 搜尋放大鏡 --}}
                <form action="{{ route('productsPage') }}"
                    class="sm:hidden flex gap-2 justify-start transition-all duration-500 ease-in-out w-5"
                    :class="isSearchInputOpen ? 'w-screen mt-1' : 'mt-0.5'">
                    <div v-if="!isSearchInputOpen" v-on:click="isSearchInputOpen = true"
                        :class="isSearchInputOpen ? 'text-gray-550' : 'text-gray-350'" class=" focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button v-else :class="isSearchInputOpen ? 'text-gray-550' : 'text-gray-350'"
                        class=" focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    <transition name="custom-classes-transition" enter-active-class="animate__fadeInRight"
                        leave-active-class="animate__fadeOutRight">
                        <div v-show="isSearchInputOpen"
                            class="animate__animated animate__faster flex items-center gap-4">
                            <input class="py-0.5 border-b-2 border-primary focus:outline-none text-black " type="search"
                                name="keyword" placeholder="Search" />
                            <span v-on:click="isSearchInputOpen = !isSearchInputOpen"
                                class="whitespace-nowrap text-sm font-bold text-gray-350">取消</span>

                        </div>

                    </transition>


                </form>
            </div>
            <div :class="isSearchInputOpen ? 'hidden sm:block' : ''"
                class="w-full text-gray-700 md:text-left text-center text-2xl font-semibold">
                <a href="/">
                    <img class="w-32 h-auto" src="{{ $setting->get('main_logo') }}" alt="DEARME">
                </a>

            </div>
            <div :class="isSearchInputOpen ? 'hidden sm:flex' : ''"
                class="text-center flex items-center justify-end w-full gap-12">
                {{-- 手機板 Menu的遮罩 --}}
                <div v-on:click="isMenuOpen = !isMenuOpen" v-if="isMenuOpen"
                    class="sm:w-0 sm:h-0 overflow-hidden fixed bg-black bg-opacity-40 h-screen top-0 right-0 w-screen z-20">
                </div>
                <nav :class="isMenuOpen ? 'w-28' : ''"
                    class="z-20 bg-white fixed font-bold h-screen left-0 sm:flex sm:h-auto sm:items-center sm:justify-center sm:relative sm:w-auto text-gray-350 text-sm top-0  overflow-x-hidden transition-all duration-700 ease-in-out w-0">
                    {{-- 手機板 Menu的關閉叉叉 --}}
                    <button v-on:click="isMenuOpen = !isMenuOpen" type="button"
                        class="pb-10 pt-5 sm:hidden text-gray-350 hover:text-gray-500 focus:outline-none focus:text-gray-500"
                        aria-label="toggle menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <div v-on:click="isMenuOpen = false" class="flex flex-col sm:flex-row gap-10">
                        @foreach ($menus as $menu)
                            @if ($menu->show_phone || $menu->show_pc)
                                <a v-on:click="move2sectionByUrlHashTag()"
                                    class="hover:underline
                            @if ($menu->show_phone && !$menu->show_pc)
                            block sm:hidden
                            @endif
                            @if (!$menu->show_phone && $menu->show_pc)
                            hidden sm:block
                            @endif
                            "
                                    href="{{ $menu->link }}">{{ $menu->name }}</a>
                            @endif
                        @endforeach

                        {{-- <a class="hover:underline" href="#">商品</a>
                        <a class="hover:underline" href="#">關於</a>
                        <a v-on:click="show_section.index=3" class="hover:underline" href="/#contact-us">聯繫</a>
                        <a class="hover:underline" href="{{route('loginPage')}}">訂單資訊</a> --}}
                    </div>
                </nav>

                {{-- 電腦板 搜尋放大鏡 --}}
                <form action="{{ route('productsPage') }}"
                    class="hidden sm:flex gap-2 justify-end transition-all duration-500 ease-in-out w-5"
                    :class="isSearchInputOpen ? 'w-60' : ''">
                    <transition name="custom-classes-transition" enter-active-class="animate__fadeInLeft"
                        lseave-active-class="animate__fadeOutLeft">
                        <input v-if="isSearchInputOpen"
                            class="animate__animated animate__faster border-b-2 border-primary focus:outline-none text-black "
                            type="search" name="keyword" placeholder="Search" />
                    </transition>
                    <div v-if="!isSearchInputOpen" v-on:click="isSearchInputOpen = true"
                        :class="isSearchInputOpen ? 'text-gray-550' : 'text-gray-350'" class=" focus:outline-none">
                        <svg class="w-5 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button v-if="isSearchInputOpen" :class="isSearchInputOpen ? 'text-gray-550' : 'text-gray-350'"
                        class=" focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
                {{-- 購物車按鈕 --}}
                <button v-on:click="cartOpen = !cartOpen" class="text-gray-350 focus:outline-none relative">
                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <span v-if="cart_items_count>0" class="-top-2 absolute bg-red-400 px-1 right-auto rounded-full text-white text-xs">@{{cart_items_count}}</span>
                </button>


            </div>
        </div>




    </div>
</header>
{{-- <div v-if="header.isSticky" class="h-40"></div> --}}

@section('JS-content')
    @parent

    <script type="text/javascript">
        mixins.push({

            data: function() {
                return {
                    header: {
                        isSticky: false,
                        showNav: true,
                    },

                    isMenuOpen: false,
                    isSearchInputOpen: false,
                }
            },

            methods: {


            },
            watch: {
                scroll_top_offset: function(pageYOffset) {
                    const vm = this;
                    if (pageYOffset > vm.$refs.header.offsetTop) {
                        vm.header.isSticky = true;
                        vm.header.showNav = false;
                    } else {
                        vm.header.isSticky = false;
                        vm.header.showNav = true;
                    }
                }
            }
        })
    </script>

@stop
