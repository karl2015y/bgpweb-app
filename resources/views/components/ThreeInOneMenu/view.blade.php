@section('body')
    @parent
      @if ($pc->data)
        <section id="{{ $pc->name }}">
    <div class="container px-5 py-12 mx-auto sm:px-32">
        <div class="relative mb-2 h-52">
            <img class="object-cover object-center w-full h-full block"
                src="{{$pc->data->images[0]->image_url??''}}" />
            <a class="absolute top-0 left-0 w-full h-full" href="{{$pc->data->Link1}}">
                <div
                    class="w-full h-full bg-black bg-opacity-40 flex flex-col justify-center items-center hover:bg-opacity-50">
                    <h1 class="text-white text-2xl font-bold text-center">{{$pc->data->Title1}}</h1>
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
                    src="{{$pc->data->images[1]->image_url??''}}" />
                <a class="absolute top-0 left-0 w-full h-full" href="{{$pc->data->Link2}}">
                    <div
                        class="w-full h-full bg-black bg-opacity-40 flex flex-col justify-center items-center hover:bg-opacity-50">
                        <h1 class="text-white text-xl sm:text-2xl font-bold text-center">{{$pc->data->Title2}}</h1>
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
                    src="{{$pc->data->images[2]->image_url??''}}" />
                <a class="absolute top-0 left-0 w-full h-full" href="{{$pc->data->Link3}}">
                    <div
                        class="w-full h-full bg-black bg-opacity-40 flex flex-col justify-center items-center hover:bg-opacity-50">
                        <h1 class="text-white text-2xl font-bold text-center">{{$pc->data->Title3}}</h1>
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
    @endif

@stop



