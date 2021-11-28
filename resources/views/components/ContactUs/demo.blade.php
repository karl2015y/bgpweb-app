@section('body')
    @parent
    <section id="demo">
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
