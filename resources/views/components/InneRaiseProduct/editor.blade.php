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
                <span class="text-gray-700">商品名稱</span>
                <input v-model="media.name" class="form-input mt-1 block w-full" />
            </label>

            <label class="block mt-4">
                <span class="text-gray-700">商品價格</span>
                <input v-model="media.price" class="form-input mt-1 block w-full" />
            </label>


            <div class="block mt-4">
                <div class="text-gray-700 mb-1">商品簡介</div>
                <textarea class="form-textarea mt-1 block w-full h-64 px-3 py-2 rounded border border-solid "
                    v-model="media.discription"></textarea>
            </div>
            <label class="block mt-4">
                <span class="text-gray-700">商品連結</span>
                <input v-model="media.link" class="form-input mt-1 block w-full" />
            </label>

          <div class="mt-4">
                <span class="text-gray-700">商品圖</span>

                <button v-on:click="addImage()"
                    class="bg-blue-400 font-bold px-4 py-1 rounded shadow-sm text-white text-xs">+新增圖片</button>

                <div class="flex flex-wrap justify-left">
                    <div v-for="(item,index) in media.images" class="w-8/12 sm:w-4/12 px-4 py-1">
                        <div class="text-center shadow">
                            <img :src="item.image_url" v-on:error="ImgError" :upload-href="item.upload_image_url"
                                class="shadow-xl rounded max-w-full h-auto align-middle border-none" />
                            <div class="text-red-500 text-sm font-bold cursor-pointer"
                                V-on:click="removeImage(index)">刪除圖片</div>
                        </div>
                    </div>
                </div>
            </div>

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
                    name: '',
                    price: '',
                    discription: '',
                    link: '',
                    images: [],
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
                ImgError: function($el) {
                    const dom = $el.target;
                    var newDom = document.createElement("a");
                    newDom.appendChild(document.createTextNode(
                        "開啟上傳頁")); //add the text node to the newly created div.
                    newDom.href = dom.getAttribute('upload-href');
                    newDom.className = "text-blue-500 text-sm font-bold";

                    dom.parentElement.appendChild(newDom);
                    dom.remove();
                },
                addImage: function() {
                    const vm = this;
                    const file_name = new Date().getTime() + '.jpg'
                    const image_path = `/images`
                    vm.media.images.push({
                        image_url: `${image_path}/${file_name}`,
                        upload_image_url: `{!! route('picuploadPage', ['w' => 720, 'h' => 480, 'back_url' => url()->current()]) !!}&path=${image_path}&filename=${file_name}`,
                    })
                    vm.$nextTick(() => {
                        vm.$refs.save_form.querySelector('button').click()
                    })
                },
                removeImage: function(index) {
                    const vm = this;
                    vm.media.images.splice(index, 1);
                    vm.$nextTick(() => {
                        vm.$refs.save_form.querySelector('button').click()
                    })
                },


            },
        })
    </script>
@stop
