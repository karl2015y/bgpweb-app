@section('body')
    @parent
    @if ($pc->data)
        <section id="{{ $pc->name }}">
        <a href="{{$pc->data->link}}">
            <div class="container flex flex-col lg:flex-row gap-16 mx-auto px-5 py-8 sm:mt-0 sm:px-32">

                <div class="w-full lg:w-7/12">
                    @if ($pc->data->images)

                        <img wh-ratio="1.5" class="w-full" src="{{ $pc->data->images[0]->image_url }}">
                    @endif

                </div>
                <div class="w-full lg:w-5/12 flex flex-col items-center justify-center">
                    <h1 class="lg:mb-10 text-gray-550 text-3xl font-bold">inneRaise 素燃錠</h1>
                    <span class="my-2 lg:my-0 lg:mb-16">{{$pc->data->price}}</span>
                    <p class="my-2 lg:my-0 lg:mt-1.5 lg:mb-16 whitespace-pre-line text-gray-350">{{$pc->data->discription}}</p>
                   <span class="my-2 lg:my-0  lg:mt-1.5 text-gray-550"></span> 完整資訊 →
                </div>

            </div>
            </a>
        </section>
    @endif



@stop


