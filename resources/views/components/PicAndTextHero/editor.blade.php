@section('content')
    <div class="flex pt-5">
        <div :class="{'w-8/12':open_editor_area, 'w-full':!open_editor_area}">
            <div class="flex justify-between items-center px-5">
                <div class="flex items-center gap-1.5"> 
                    <a href="{{route('PageComponentsPage', $pc->pages_id)}}" class="inline-block text-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold inline-block">預覽區</h1>
                </div>
                <div>
                    <button v-if="!open_editor_area" @click.stop="toggleEditorMediaArea()"
                        class="bg-gray-200 border-0 focus:outline-none font-bold hover:bg-indigo-600 inline-block mr-2 p-2 rounded text-sm text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>
            </div>
            <section class="text-gray-600 body-font overflow-auto h-screen">
                <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                    <div
                        class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                        <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                            <template v-if="medias.text_1.show">@{{ medias . text_1 . text }}</template>
                            <br class="hidden lg:inline-block">
                            <template v-if="medias.text_2.show">@{{ medias . text_2 . text }}</template>
                        </h1>
                        <p v-if="medias.text_3.show" class="mb-8 leading-relaxed">@{{ medias . text_3 . text }}</p>
                        <div class="flex justify-center">
                            <a v-if="medias.button_1.show" :href="medias.button_1.text"
                                class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg mr-4">@{{ medias . button_1 . text }}</a>
                            <a v-if="medias. button_2.show" :href="medias.button_2.text"
                                class="inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">@{{ medias . button_2 . text }}</a>


                        </div>
                    </div>
                    <div v-if="medias.pic_1.show" class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                        <a v-if="medias.pic_1.uploaded" :href="medias.pic_1.link">
                            <img class="object-cover object-center rounded" :alt="medias.pic_1.text"
                                :src="`/storage/PageComponent/{{ $pc->id }}/pic_1.jpg?t=${Math.floor(Math.random()*10000)}`"
                                :width="medias.pic_1.w" :height="medias.pic_1.h">
                        </a>
                        <img v-else class="object-cover object-center rounded" alt="假圖"
                            :src="`https://dummyimage.com/${medias.pic_1.w}x${medias.pic_1.h}`" :width="medias.pic_1.w"
                            :height="medias.pic_1.h/10">
                    </div>
                </div>
            </section>
        </div>

        <div v-show="open_editor_area" class="w-4/12 border-solid border-l border-gray-200 px-1">
            <div class="flex justify-between items-center px-5 mb-2">
                <div>
                    <h1 class="text-2xl font-bold inline-block">編輯區</h1>
                    <span class="text-sm block text-gray-500">上次更新日期：<br>
                        {{ $pc->updated_at }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <form
                        action="{{ route('PageComponentsEdit', ['pages_id' => $pc->pages_id, 'page_components_id' => $pc->id]) }}"
                        method="post" class="inline leading-5">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="data" :value="JSON.stringify(medias)">
                        <button class="btn btn-sec btn-rwd">儲存</button>
                    </form>

                    <button @click.stop="toggleEditorMediaArea()"
                        class="bg-gray-200 border-0 focus:outline-none font-bold hover:bg-indigo-600 inline-block mr-2 p-2 rounded text-sm text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
            <section class="h-screen overflow-auto pb-20">
                <div class="bg-gray-50 p-5 rounded shadow">
                    <template v-for="(item, key) in medias">
                        {{-- 文字 --}}
                        <div v-if="item.type=='text'" class="p-2 border-solid border-b border-gray-300">
                            <label :for="`${key}.text`">文字_@{{ key }}</label>
                            <input v-model="item.text" :id="`${key}.text`"
                                class="ml-2 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full "
                                type="text">

                            <div class="mt-2">
                                <input v-model="item.show" :id="`${key}.show`" type="checkbox">
                                <label :for="`${key}.show`">顯示文字</label>
                            </div>
                        </div>

                        {{-- 按鈕 --}}
                        <div v-if="item.type=='button'" class="p-2 border-solid border-b border-gray-300 flex">
                            <div class="pt-3 w-20">
                                <span>按鈕_@{{ key }}</span>
                            </div>
                            <div class="ml-5 w-full">
                                <label :for="`${key}.text`">文字</label>
                                <input v-model="item.text" :id="`${key}.text`"
                                    class="ml-2 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full "
                                    type="text">
                                <br>

                                <label :for="`${key}.link`">連結</label>
                                <input v-model="item.link" :id="`${key}.link`"
                                    class="ml-2 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full "
                                    type="text">
                                <br>
                                <div class="mt-2">
                                    <input v-model="item.show" :id="`${key}.show`" type="checkbox">
                                    <label :for="`${key}.show`">顯示按鈕</label>
                                </div>

                            </div>
                        </div>

                        {{-- 單張圖片 --}}
                        <div v-if="item.type=='pic'" class="p-2 border-solid border-b border-gray-300 flex">
                            <div class="pt-3 w-20">
                                <span>圖片_@{{ key }}</span><br>
                                <span>(@{{ item . w }}x@{{ item . h }})</span><br>
                            </div>
                            <div class="ml-5 w-full">
                                <label :for="`${key}.text`">文字說明圖片</label>
                                <input v-model="item.text" :id="`${key}.text`"
                                    class="ml-2 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full "
                                    type="text">
                                <br>

                                <form action="{{ route('picuploadPage') }}" method="get">
                                    <input type="hidden" name="w" :value="`${item.w}px`">
                                    <input type="hidden" name="h" :value="`${item.h}px`">
                                    <input type="hidden" name="path" value="PageComponent/{{ $pc->id }}">
                                    <input type="hidden" name="filename" :value="key">
                                    <img v-if="item.uploaded" class="mt-3 shadow"
                                        :src="`/storage/PageComponent/{{ $pc->id }}/${key}.jpg?t=${Math.floor(Math.random()*10000)}`"
                                        v-on:error="item.uploaded=false" :width="item.w/10" height="item.h/10">
                                    <button
                                        class="w-full mt-3 bg-indigo-500 border-0 focus:outline-none font-bold hover:bg-indigo-600 inline-block mr-2 p-2 rounded text-sm text-white">
                                        上傳圖片
                                    </button>
                                </form>
                                <br>
                                <div class="mt-2">
                                    <input v-model="item.show" :id="`${key}.show`" type="checkbox">
                                    <label :for="`${key}.show`">顯示圖片</label>
                                </div>

                            </div>
                        </div>
                    </template>







                </div>
            </section>
        </div>

    </div>



@stop

@section('JS-content')
    <script type="text/javascript">
        var app = new Vue({
            el: '#app',
            data: {
                /* @if($pc->data)*/
                medias: {!! $pc->data !!},
                /* @else */
                medias: {"text_1":{"type":"text","show":true,"text":"Before they sold out"},"text_2":{"type":"text","show":true,"text":"readymade gluten"},"text_3":{"type":"text","show":true,"text":"Copper mug try-hard pitchfork pour-over freegan heirloom neutra air plant cold-pressed tacos poke beard tote bag. Heirloom echo park mlkshk tote bag selvage hot chicken authentic tumeric truffaut hexagon try-hard chambray."},"button_1":{"type":"button","show":true,"text":"Button1","link":"https://www.google.com/"},"button_2":{"type":"button","show":true,"text":"Button2","link":"https://www.google.com/tw"},"pic_1":{"type":"pic","show":true,"text":"Hero","link":"http://dummyimage.com/720x600","uploaded":true,"w":720,"h":600}},
                /* @endif */
                open_editor_area: false,
            },
            methods: {
                toggleEditorMediaArea: function() {
                    this.open_editor_area = !this.open_editor_area;
                },
            },
        })
    </script>
@stop
