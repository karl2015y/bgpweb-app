<transition name="scroll-top">
    <div v-on:click.stop="scroll2Top()" v-if="footer_show_scroll2Top_button"
        class="animate__animated cursor-pointer fixed w-14 h-14 rounded-full flex justify-center items-center shadow-2xl bg-blue-600 text-white bottom-6 right-7">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
        </svg>
    </div>
</transition>




<footer class="text-gray-600 body-font " :class="{'fixed w-screen left-0 bottom-0':!footer.is_long_page}">

    <div class="bg-brown">
        <div class="container px-5 py-6 mx-auto flex items-center sm:flex-row flex-col">
            <a href="/" class="flex title-font font-medium items-center md:justify-start justify-center text-gray-350">
                <img class="w-72 sm:w-32 h-auto" src="{{ $setting->get('sec_logo') }}" alt="DEARME">

            </a>
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

            <span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start gap-3">
                @if ($setting->get('facebook_link'))
                    <a href="{{ $setting->get('facebook_link') }}"
                        class="{{ $setting->get('facebook_icon_color') }} hover:{{ $setting->get('facebook_icon_hover_color') }}">
                        <i class="{{ $setting->get('facebook_icon') }}"></i>
                    </a>
                @endif
                @if ($setting->get('instagram_link'))
                    <a href="{{ $setting->get('instagram_link') }}"
                        class="{{ $setting->get('instagram_icon_color') }} hover:{{ $setting->get('instagram_icon_hover_color') }}">
                        <i class="{{ $setting->get('instagram_icon') }}"></i>
                    </a>
                @endif
                @if ($setting->get('twitter_link'))
                    <a href="{{ $setting->get('twitter_link') }}"
                        class="{{ $setting->get('twitter_icon_color') }} hover:{{ $setting->get('twitter_icon_hover_color') }}">
                        <i class="{{ $setting->get('twitter_icon') }}"></i>
                    </a>
                @endif
                @if ($setting->get('line_link'))
                    <a href="{{ $setting->get('line_link') }}"
                        class="{{ $setting->get('line_icon_color') }} hover:{{ $setting->get('line_icon_hover_color') }}">
                        <i class="{{ $setting->get('line_icon') }}"></i>
                    </a>
                @endif
            </span>
        </div>
    </div>
</footer>


@section('JS-content')
    @parent

    <script type="text/javascript">
        mixins.push({
            data: function() {
                return {
                    footer: {
                        is_scroll_on_bottom: false,
                        is_long_page: true,
                    },
                };
            },




            computed: {
                footer_show_scroll2Top_button() {
                    const vm = this;
                    return vm.scroll_top_offset > 10 && !vm.footer.is_scroll_on_bottom;
                },

            },
            methods: {
                scroll2Top: function() {
                    window.scrollTo({
                        top: 0,
                        left: 0,
                        behavior: 'smooth'
                    });
                    if (this.show_section && this.show_section.index) {
                        this.show_section.index = 0;
                    }
                },
                check_page_is_long: function() {
                    this.footer.is_long_page = document.body.scrollHeight > window.innerHeight
                }


            },
            watch: {
                scroll_top_offset: function(pageYOffset) {
                    const vm = this;
                    vm.$nextTick(function() {
                        vm.footer.is_scroll_on_bottom = (window.innerHeight + pageYOffset) + 10 >=
                            document
                            .body.offsetHeight;
                    })

                }
            },
            mounted: function() {
                const vm = this;
                vm.$nextTick(() => {
                    setTimeout(() => {
                        vm.footer.is_long_page = document.body.scrollHeight > window
                            .innerHeight;
                        console.log('is_long_page', this.footer.is_long_page)

                    }, 1000)

                })

            },

        })
    </script>

@stop
