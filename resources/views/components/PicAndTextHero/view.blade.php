
    <section id="{{ $pc->name }}" class="text-gray-600 body-font">
        <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
            <div
                class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                    @if ($pc->data->text_1->show)
                        {{ $pc->data->text_1->text }}
                    @endif
                    <br class="hidden lg:inline-block">
                    @if ($pc->data->text_2->show)
                        {{ $pc->data->text_2->text }}
                    @endif
                </h1>
                @if ($pc->data->text_3->show)
                    <p class="mb-8 leading-relaxed">{{ $pc->data->text_3->text }}</p>
                @endif
                <div class="flex justify-center">
                    @if ($pc->data->button_1->show)
                        <a href="{{ $pc->data->button_1->link }}"
                            class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg mr-4">{{ $pc->data->button_1->text }}</a>
                    @endif
                    @if ($pc->data->button_2->show)
                        <a href="{{ $pc->data->button_2->link }}"
                            class="inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">{{ $pc->data->button_2->text }}</a>
                    @endif

                </div>
            </div>
            @if ($pc->data->pic_1->show)
                <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                    @if ($pc->data->pic_1->uploaded)
                        <img class="object-cover object-center rounded" alt="{{ $pc->data->pic_1->text }}"
                            src="/storage/PageComponent/{{ $pc->id }}/pic_1.jpg?t={{ rand() }}"
                            width="{{ $pc->data->pic_1->w }}" height="{{ $pc->data->pic_1->h }}">
                    @else
                        <img class="object-cover object-center rounded" alt="假圖"
                            src='{{ "https://dummyimage.com/{$pc->data->pic_1->w}x{$pc->data->pic_1->h}" }}'
                            width="{{ $pc->data->pic_1->w }}" height="{{ $pc->data->pic_1->h }}">
                    @endif
                </div>
            @endif
        </div>
    </section>

