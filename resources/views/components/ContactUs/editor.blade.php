@section('content')
    @parent
    <section id="demo">
        <!-- Required form plugin -->
        <link href="https://cdn.jsdelivr.net/npm/@tailwindcss/custom-forms@0.2.1/dist/custom-forms.css" rel="stylesheet" />

        <a href="{{ route('PageComponentsPage', $pc->pages_id) }}"
            class="inline-block text-blue-300 fixed left-5 top-5 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            返回
        </a>

        <form ref="save_form"
            action="{{ route('PageComponentsEdit', ['pages_id' => $pc->pages_id, 'page_components_id' => $pc->id]) }}"
            method="post" class="fixed right-5 top-5 leading-5">
            @csrf
            @method('PUT')
            <input type="hidden" name="data" :value="JSON.stringify(media)">
            <button class="btn btn-sec btn-rwd">儲存</button>
        </form>

        <div class="p-4 shadow-md rounded-md text-left mx-auto mt-10 w-full sm:w-8/12">



            <label class="block">
                <span class="text-gray-700">標題</span>
                <input v-model="media.title" class="form-input mt-1 block w-full" />
            </label>

            <label class="block mt-4">
                <span class="text-gray-700">說明</span>
                <input v-model="media.discription" class="form-input mt-1 block w-full" />
            </label>


 

        </div>

    </section>


@stop


@section('JS-content')
    @parent
    <script type="text/javascript">
        var app = new Vue({
            el: '#app',
            data: {
                media: {
                    title: '',
                    discription: '',
                    
                }
            },
            created: function() {
                const vm = this;

                /*
                 @if ($pc->data != '{}')*/
                     vm.media = {!! $pc->data !!};
                     /*@endif*/
            },
            methods: {
      

            },
        })
    </script>
@stop
