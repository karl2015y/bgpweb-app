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
            <input type="hidden" name="data" :value="JSON.stringify(agile_datas)">
            <button class="btn btn-sec btn-rwd">儲存</button>
        </form>

        <div class="p-4 shadow-md rounded-md text-left mx-auto mt-10 w-full sm:w-8/12">


            <div>
                <span class="text-gray-700">控制點點方向</span>
                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input v-model="agile_datas.position" type="radio" class="form-radio" name="accountType"
                            value="left" />
                        <span class="ml-2">左邊</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input v-model="agile_datas.position" type="radio" class="form-radio" name="accountType"
                            value="right" />
                        <span class="ml-2">右邊</span>
                    </label>
                </div>
            </div>

            <label class="block mt-4">
                <span class="text-gray-700">桌面寬高比(W/H)</span>
                <input v-model="agile_datas.desktop_wh_ratio" class="form-input mt-1 block w-full" />
            </label>
            <div class="mt-4">
                <span class="text-gray-700">桌面圖</span>

                <button v-on:click="addDesktopImage()"
                    class="bg-blue-400 font-bold px-4 py-1 rounded shadow-sm text-white text-xs">+新增圖片</button>

                <div class="flex flex-wrap justify-left">
                    <div v-for="(item,index) in agile_datas.desktop_images" class="w-8/12 sm:w-4/12 px-4 py-1">
                        <div class="text-center shadow">
                            <label class="block ">
                                <span class="text-gray-700">點擊連結</span>
                                <input name="value" v-model="item.link" type="text"
                                    class="px-3 py-1 rounded border-solid border border-gray-200 form-input my-1 mx-auto"
                                    placeholder="" />
                            </label>
                            <img :src="item.image_url" v-on:error="ImgError" :upload-href="item.upload_image_url"
                                class="shadow-xl rounded max-w-full h-auto align-middle border-none" />
                            <div class="text-red-500 text-sm font-bold cursor-pointer"
                                V-on:click="removeDesktopImage(index)">刪除圖片</div>
                        </div>
                    </div>
                </div>
            </div>

            <label class="block mt-4">
                <span class="text-gray-700">手機寬高比(W/H)</span>
                <input v-model="agile_datas.phone_wh_ratio" class="form-input mt-1 block w-full" />
            </label>

            <div class="mt-4">
                <span class="text-gray-700">手機圖</span>
                <button v-on:click="addPhoneImage()"
                    class="bg-blue-400 font-bold px-4 py-1 rounded shadow-sm text-white text-xs">+新增圖片</button>

                <div class="flex flex-wrap justify-left">
                    <div v-for="(item,index) in agile_datas.phone_images" class="w-8/12 sm:w-4/12 px-4 py-1">
                        <div class="text-center shadow">
                            <label class="block ">
                                <span class="text-gray-700">點擊連結</span>
                                <input name="value" v-model="item.link" type="text"
                                    class="px-3 py-1 rounded border-solid border border-gray-200 form-input my-1 mx-auto"
                                    placeholder="" />
                            </label>
                            <img :src="item.image_url" v-on:error="ImgError" :upload-href="item.upload_image_url"
                                class="shadow-xl rounded max-w-full h-auto align-middle border-none" />
                            <div class="text-red-500 text-sm font-bold cursor-pointer" V-on:click="removePhoneImage(index)">
                                刪除圖片</div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </section>


@stop


@section('JS-content')
    @parent
    {{-- <script src="/plugins/VueAgile/VueAgile.min.js"></script> --}}
    <script type="text/javascript">
        var app = new Vue({
            el: '#app',
            components: {
                {{-- agile: VueAgile --}}
            },
            data: {
                agile_datas: {
                    position: 'left',
                    desktop_wh_ratio: '2',
                    phone_wh_ratio: '0',
                    desktop_images: [],
                    phone_images: [],
                }
            },
            created: function() {
                const vm = this;

                /*
                 @if ($pc->data != '{}')*/
                     vm.agile_datas = {!! $pc->data !!};
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
                    dom.parentElement.querySelector('label').remove();
                    dom.remove();
                },
                addDesktopImage: function() {
                    const vm = this;
                    const file_name = new Date().getTime() + '.jpg'
                    const image_path = `/images`
                    vm.agile_datas.desktop_images.push({
                        link: '',
                        image_url: `${image_path}/${file_name}`,
                        upload_image_url: `{!! route('picuploadPage', ['w' => 1600, 'h' => 800, 'back_url' => url()->current()]) !!}&path=${image_path}&filename=${file_name}`,
                    })
                    vm.$nextTick(() => {
                        vm.$refs.save_form.querySelector('button').click()
                    })
                },
                removeDesktopImage: function(index) {
                    const vm = this;

                    vm.agile_datas.desktop_images.splice(index, 1);
                    vm.$nextTick(() => {
                        vm.$refs.save_form.querySelector('button').click()
                    })
                },
                addPhoneImage: function() {
                    const vm = this;
                    const file_name = new Date().getTime() + '.jpg'
                    const image_path = `/images`
                    vm.agile_datas.phone_images.push({
                        link: '',
                        image_url: `${image_path}/${file_name}`,
                        upload_image_url: `{!! route('picuploadPage', ['w' => 375, 'h' => 756, 'back_url' => url()->current()]) !!}&path=${image_path}&filename=${file_name}`,
                    })
                    vm.$nextTick(() => {
                        vm.$refs.save_form.querySelector('button').click()
                    })
                },

                removePhoneImage: function(index) {
                    const vm = this;

                    vm.agile_datas.phone_images.splice(index, 1);
                    vm.$nextTick(() => {
                        vm.$refs.save_form.querySelector('button').click()
                    })
                },

            },
        })
    </script>
@stop
