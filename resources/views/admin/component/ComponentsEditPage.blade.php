@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '元件管理-編輯')
@section('Breadcrumb')
    <a href="{{ route('ComponentsPage') }}" class="text-blue-600">列表</a>
    <span class="px-1">»</span>
    <span class="text-gray-400">編輯</span>
@stop



@section('content')

    <form action="{{ route('ComponentsEdit', $component->id) }}" method="post">
        <div class=" p-5 bg-white rounded shadow">
            @csrf
            @method('PUT')




            <div>
                <label for="show_name" class="font-bold">
                    <span class="text-red-500">*</span>
                    元件顯示名稱
                </label>
                <input placeholder="輸入元件的顯示名稱" name="show_name" value="{{ old('show_name', $component->show_name) }}"
                    class="ml-2 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full lg:w-60"
                    type="text" id="show_name" />
            </div>


            <div class="mt-3">
                <label for="name" class="font-bold">
                    <span class="text-red-500">*</span>
                    元件程式名稱
                </label>
                <input placeholder="輸入元件對應的程式名稱" name="name" value="{{ old('name', $component->name) }}"
                    class="ml-2 px-4 py-3 leading-5 border rounded-md focus:outline-none focus:ring focus:border-blue-400 w-full lg:w-60"
                    type="text" id="name" />
            </div>




            <div class="mt-3">
                <label for="link" class="font-bold">
                    <span class="text-red-500">*</span>
                    元件類型
                </label>
                <div class="flex lg:inline-block w-full lg:w-96">
                    <div class="mx-3 lg:ml-10 lg:mr-0 relative inline-block w-full lg:w-60 text-gray-700">
                        <select @change="toggleClassificationChooseStatus()" v-model="classification_selected"
                            class="appearance-none border focus:border-blue-400 focus:outline-none h-10 pl-3 placeholder-gray-600 pr-6 rounded-lg text-base w-full"
                            placeholder="Regular input">
                            <option value="0" disabled hidden>請選擇類型，並點擊新增</option>
                            <option v-if="canChoose_classifications_list.length==0" disabled>無選項</option>
                            <template v-else v-for="item in canChoose_classifications_list">
                                <option v-if="!item.chosen" :value="item">@{{ item . name }}</option>
                            </template>

                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <button type="button" @click.stop="toggleClassificationChooseStatus()" style="margin-top: 0;"
                        class="btn btn-main btn-rwd inline leading-5 max-w-max">新增</button>

                </div>
                <div class="ml-4 mt-2 lg:ml-32 lg:mt-3">
                    <template v-for="item in canNotChoose_classifications_list">
                        <span v-if="item.chosen">@{{ item . name }}</span>
                        <button type="button" @click.stop="toggleClassificationChooseStatus(item)" style="margin-top: 0;"
                            class="btn btn-third btn-sm text-sm inline leading-5 max-w-max">刪除</button>
                        <br />
                    </template>
                    <input name="component_classifies" class="hidden" type="text"
                        :value="choose_classifications_list">
                </div>
            </div>

        </div>
        <div class="mt-4 text-right">
            <button class="btn btn-sec btn-rwd inline leading-5">儲存</button>
            <a href="{{ route('ComponentsPage') }}" class="btn btn-fourth btn-rwd">取消</a>
        </div>
    </form>


@stop


@section('JS-content')
    <script type="text/javascript">
        var app = new Vue({
            el: '#app',
            data: {
                classification_selected: 0,
                classifications_list: [

                    // @foreach ($classify as $class_data)
                    
                        { id: "{{ $class_data->id }}",name: "{{ $class_data->name }}",chosen: false},
                    
                    // @endforeach

                ]
            },
            methods: {
                toggleClassificationChooseStatus: function(classification) {
                    if (classification) {
                        classification.chosen = !classification.chosen
                        this.classification_selected = 0
                    } else if (this.classification_selected) {
                        this.toggleClassificationChooseStatus(this.classification_selected)
                    }
                }
            },
            computed: {
                canNotChoose_classifications_list: function() {
                    return this.classifications_list.filter((item) => item.chosen)
                },
                canChoose_classifications_list: function() {
                    return this.classifications_list.filter((item) => !item.chosen)
                },
                choose_classifications_list: function() {
                    return this.canNotChoose_classifications_list.map((item) => item.id).toString()
                },
            },
            created: function() {
                    // @foreach ($component->classifications as $classification)
                    
                    this.classifications_list.find((item)=>item.id=="{{$classification->classifies_id}}").chosen=true

                    // @endforeach

            }
        })
    </script>
@stop
