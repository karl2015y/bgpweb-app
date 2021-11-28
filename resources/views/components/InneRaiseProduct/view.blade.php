@section('body')
    @parent
    @if ($pc->data)
        <section id="{{ $pc->name }}">
            <div class="container flex flex-col lg:flex-row gap-16 mx-auto px-5 py-8 sm:mt-0 sm:px-32">

                <div class="w-full lg:w-7/12">
                    @if ($pc->data->images)

                        <img wh-ratio="1.5" class="w-full" src="{{ $pc->data->images[0]->image_url }}">
                    @endif

                </div>
                <div class="w-full lg:w-5/12 gap-5 flex flex-col items-center justify-around">
                    <h1 class="text-gray-550 text-3xl font-bold">inneRaise 素燃錠</h1>
                    <span>{{$pc->data->price}}</span>
                    <p class="whitespace-pre-line text-gray-350">{{$pc->data->discription}}</p>
                    <a class="text-gray-550" href="{{$pc->data->link}}">完整資訊 →</a>
                </div>

            </div>
        </section>
    @endif



@stop


