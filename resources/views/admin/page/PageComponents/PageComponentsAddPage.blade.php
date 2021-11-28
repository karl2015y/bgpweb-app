@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', $page->title)


@section('Breadcrumb')
    <a href="{{ route('PagesPage') }}" class="text-blue-600">頁面列表</a>
    <span class="px-1">»</span>
    <a href="{{ route('PageComponentsPage', $page->id) }}" class="text-blue-600">元件列表</a>
    <span class="px-1">»</span>
    <span class="text-gray-400">新增元件</span>
@stop

@section('content')
    {{-- 篩選器與按鈕區 --}}
    <div class="block items-center justify-between lg:flex ">
        <div class="mt-5 lg:mt-0 w-full lg:w-96">
            {{-- 展開元件篩選器 --}}
            {{-- <div>
            展開元件篩選器 ▾
           </div> --}}
            <div>
                <div class="mb-1">
                    <span>元件類別</span>
                </div>
                <div class="relative inline-block w-full text-gray-700">
                    <select @change="changeClassHandler()" v-model="classification_selected"
                        class="appearance-none border focus:border-blue-400 focus:outline-none h-10 pl-3 placeholder-gray-600 pr-6 rounded-lg text-base w-full"
                        placeholder="Regular input">
                        <option value="all">全部({{ $components_count }})</option>
                        @foreach ($classify as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}({{ $class->components_count }})
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div>
        </div>


    </div>


    {{-- title --}}
    <div
        class="mt-2 hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
        <div class="border-r border-solid w-1/4 text-center border-gray-200">元件顯示名稱</div>
        <div class="border-r border-solid w-1/4 text-center border-gray-200">元件程式名稱</div>
        <div class="border-r border-solid w-1/4 text-center border-gray-200">元件類型</div>
        <div class="w-1/4 text-center border-gray-200">操作</div>
    </div>
    @forelse ($components as $component)
        {{-- content start --}}
        <div
            class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">
            <div class="lg:border-r border-solid w-full lg:w-1/4 text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold">元件顯示名稱</div>
                    <div>{{ $component->name }}</div>
                </div>
            </div>
            <div class="lg:border-r border-solid w-full lg:w-1/4 text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5">
                    <div class="lg:hidden font-bold">元件程式名稱</div>
                    <div>{{ $component->show_name }}</div>
                </div>
            </div>
            <div class="lg:border-r border-solid w-full lg:w-1/4 text-center border-gray-200">
                <div class="flex justify-between lg:block mt-1.5 overflow-auto">
                    <div class="lg:hidden font-bold">元件類型</div>
                    <div>
                        @foreach ($component->classifications as $class_data)

                            @if ($loop->last)
                                <a class="text-blue-500"
                                    href="{{ route('PageComponentsAddPage', ['pages_id'=>$page->id,'class_id' => $class_data->classify->id]) }}">{{ $class_data->classify->name }}</a>
                            @else
                                <a class="text-blue-500"
                                    href="{{ route('PageComponentsAddPage', ['pages_id'=>$page->id,'class_id' => $class_data->classify->id]) }}">{{ $class_data->classify->name }}</a>
                                <span>, </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/4 text-center border-gray-200">
                <a target="_blank" href="{{ route('ComponentsPreviewPage',  $component->id ) }}" class="btn btn-fourth btn-rwd">預覽</a>
                <form action="{{ route('PageComponentsAdd',  $page->id ) }}" method="post" class="inline leading-5">
                    @csrf
                    <input name="components_id" type="hidden" value="{{$component->id}}">
                    <button onClick='return confirmSubmit()' class="btn btn-main btn-rwd">加入頁面</button>
                </form>

            </div>


        </div>
        {{-- content end --}}
    @empty
        <p class="text-center p-5 bg-white mt-2 rounded shadow">無資料</p>
    @endforelse
    <br>
    {{ $components->links() }}
@stop

@section('JS-content')
    <script type="text/javascript">
        function confirmSubmit(){
            var agree=confirm("是否繼續?");
            if (agree) return true ;
            else return false ;
        }
    </script>
    <script type="text/javascript">
        var app = new Vue({
            el: '#app',
            data: {
                classification_selected: null,
            },
            methods: {
                changeClassHandler: function() {
                    console.log('hi')
                    const vm = this
                    const link = "{{ route('PageComponentsAddPage',['pages_id'=>$page->id]) }}"
                    if (vm.classification_selected == 'all') {
                        console.log('1')
                        window.location.href = link
                    } else {
                        console.log('2')
                        window.location.href = `${link}?class_id=${vm.classification_selected}`
                    }

                },
                getUrlParameter: function(name) {
                    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                    var results = regex.exec(location.search);
                    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
                }
            },
            created: function() {
                // `this` points to the vm instance
                if (this.getUrlParameter('class_id')) {
                    this.classification_selected = this.getUrlParameter('class_id')
                } else {
                    this.classification_selected = 'all'
                }
            }
        })
    </script>
@stop
