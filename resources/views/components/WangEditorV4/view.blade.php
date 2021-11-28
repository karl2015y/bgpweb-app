@section('body')
    @parent
    @if ($pc->data)
        <section id="{{ $pc->name }}">   
        <div class="container flex flex-col mx-auto px-5 py-8 sm:mt-0 sm:px-32">
         {!! $pc->data->description !!}
        </div>
        </section>
    @endif



@stop


