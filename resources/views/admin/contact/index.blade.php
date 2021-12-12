@extends('admin.layouts.main')

@section('title', '背景模式後台')
@section('classification-name', '聯絡我們管理')

@section('Breadcrumb')
    <div class="flex justify-between w-full flex-col lg:flex-row ">
        <div>
            {{-- <span>※ 訂單狀態「待付款」→「已付款(銀行驗證中)」→「已付款」→「揀貨中」→「已出貨」</span>
            <br>
            <span>※ 揀貨主要是告訴消費者，廠商已經確定該訂單的資訊，正在準備出貨</span> --}}
            {{-- 麵包屑 --}}
            <nav class="col-span-2">
                <ol class="list-reset py-4 pl-2 rounded flex bg-grey-light text-grey">
                    {{-- <li><a href="{{ route('ordersPage') }}" class="no-underline text-blue-400">訂單列表</a></li>
                    <li class="px-2">/</li> --}}
                    <li class="text-gray-400">聯絡單列表</li>
                </ol>
            </nav>

        </div>
        <div>
            {{-- <a href="{{ route('coupon.create') }}">
                <button v-if="filter_target!='Owner'" class="btn btn-fourth btn-rwd">新增優惠券</button>
            </a> --}}
            <form ref="form_edit" method="POST" action="">
                @csrf
                @method('PUT')
                <input class="hidden" type="text" name="status">
                <input type="submit" class="hidden">
            </form>

        </div>

    </div>
@stop

@section('content')
    {{-- 篩選器 --}}

    <form action="" method="get">
        <input class="hidden" id="changeTableStatus" type="submit" value="">
        <input class="hidden" v-model="filter_target" type="text" name="filter">
        <div v-on:click="clickFliter()" class="flex text-sm overflow-x-auto sm:ml-0 mb-3 sm:mb-0">
            <template v-for="(item, index) in filter_option">
                <div v-if="index==0" v-on:click="filter_target=item.val"
                    :class="filter_target==item.val?'bg-blue-500 text-white border-blue-500':''"
                    class="whitespace-nowrap inline-flex rounded-l-lg border border-double border-r-0 border-gray-300 radio text-center self-center py-1 px-4  cursor-pointer ">
                    @{{ item . text }}
                </div>

                <div v-else-if="index == filter_option.length - 1" v-on:click="filter_target=item.val"
                    :class="filter_target==item.val?'bg-blue-500 text-white border-blue-500':''"
                    class="whitespace-nowrap inline-flex rounded-r-lg  border border-double border-gray-300 radio text-center self-center py-1 px-4  cursor-pointer ">
                    @{{ item . text }}
                </div>
                <div v-else v-on:click="filter_target=item.val"
                    :class="filter_target==item.val?'bg-blue-500 text-white border-blue-500':''"
                    class="whitespace-nowrap inline-flex border border-double border-r-0 border-gray-300 radio text-center self-center py-1 px-4  cursor-pointer ">
                    @{{ item . text }}
                </div>
            </template>


        </div>
    </form>


    {{ $contacts->links() }}



    <div class="my-2">

        {{-- title --}}
        <div
            class="hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
            <div class="border-r border-solid w-full text-center border-gray-200">狀態</div>
            <div class="border-r border-solid w-full text-center border-gray-200">建立時間</div>
            <div class="border-r border-solid w-full text-center border-gray-200">更新時間</div>
            <div class="border-r border-solid w-full text-center border-gray-200">聯絡人姓名</div>
            <div class="border-r border-solid w-full text-center border-gray-200">聯絡方式</div>
            <div class="border-r border-solid w-full text-center border-gray-200">問題</div>
            <div v-if="filter_target!='Delete'" class="border-r border-solid w-full text-center border-gray-200">操作</div>
        </div>
        @forelse  ($contacts as $contact)
            {{-- content start --}}
            <div
                class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">
                {{-- 狀態 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">狀態</div>
                        <div class=" flex flex-col justify-center items-center text-gray-350">
                            @if ($contact->status == '未處理')
                                <span class="text-xs bg-red-300 rounded text-white w-10">未處理</span>
                            @elseif ($contact->status == '處理中')
                                <span class="text-xs bg-yellow-300 rounded text-white w-10">處理中</span>
                            @elseif ($contact->status == '已處理')
                                <span class="text-xs bg-green-300 rounded text-white w-10">已處理</span>
                            @else
                                <span class="text-xs">未定義</span>

                            @endif

                        </div>
                    </div>
                </div>

                {{-- 建立時間 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">建立時間</div>
                        <div class=" flex justify-center text-gray-350 flex-col gap-2">
                            <span class="text-sm">{{ $contact->created_at }}</span>
                            <span class="text-xs">({{ $contact->created_at->diffForhumans() }})</span>
                        </div>
                    </div>
                </div>
                {{-- 更新時間 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">更新時間</div>
                        <div class=" flex justify-center text-gray-350 flex-col gap-2">
                            <span class="text-sm">{{ $contact->updated_at }}</span>
                            <span class="text-xs">({{ $contact->updated_at->diffForhumans() }})</span>
                        </div>
                    </div>
                </div>
                {{-- 聯絡人姓名 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">聯絡人姓名</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $contact->name }}</span>
                        </div>
                    </div>
                </div>


                {{-- 聯絡方式 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">聯絡方式</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $contact->email }}</span>
                        </div>
                    </div>
                </div>
                {{-- 問題 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">問題</div>
                        <div class=" flex justify-center text-gray-350">
                            <p class="text-sm whitespace-pre-line text-left">{{ $contact->message }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200 ">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="text-gray-350  w-full">


                            <button
                            v-if="filter_target!='處理中'"
                                v-on:click="check2Ing('{{ route('contact.update', [$contact->id]) }}')"
                                class="btn btn-sec btn-rwd btn-sm  text-sm">切換成「處理中」</button>

                            <button
                                v-if="filter_target!='已處理'"
                                v-on:click="check2Done('{{ route('contact.update', [$contact->id]) }}')"
                                class="btn bg-green-500 text-white btn-rwd btn-sm  text-sm">切換成「已處理」</button>


                        </div>
                    </div>


                </div>


            </div>
            {{-- content end --}}
        @empty
            <div class="border-solid border-gray-100 border rounded p-5 bg-white text-center mt-2 shadow-sm">目前沒有資料喔</div>
        @endforelse
    </div>


    {{ $contacts->links() }}

@stop

@section('JS-content')
    @parent




    <script>
        var app = new Vue({
            el: '#app',
            data: {
                filter_target: 'Now',
                filter_option: [{
                        val: '未處理',
                        text: '未處理',
                    }, {
                        val: '處理中',
                        text: '處理中',
                    },
                    {
                        val: '已處理',
                        text: '已處理',
                    }

                ],



                selectOrderIds: {}
            },

            computed: {
                selectOrderIdCount() {
                    return Object.entries(this.selectOrderIds).filter(item => item[1])
                },

            },

            created: function() {
                this.filter_target = this.getUrlQuery('filter') ? this.getUrlQuery('filter') : '未處理';
            },
            methods: {
                clickFliter: function() {
                    document.querySelector('#changeTableStatus').click()
                },
                getUrlQuery: function(query) {
                    const urlSearchParams = new URLSearchParams(window.location.search);
                    const params = Object.fromEntries(urlSearchParams.entries());
                    if (params[query]) {
                        return params[query];
                    }
                    return '';
                },
                check2Ing: function(url) {
                    const vm = this;


                    Swal.fire({
                        title: '是否將狀態改為處理中？',
                        showCancelButton: true,
                        confirmButtonText: '是',
                        cancelButtonText: `否`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            const dom = vm.$refs.form_edit;
                            dom.action = url;
                            dom.querySelector('input[name=status]').value = "處理中"
                            dom.querySelector('input[type=submit]').click()
                        }
                    })
                },
                check2Done: function(url) {
                    const vm = this;


                    Swal.fire({
                        title: '是否將狀態改為已處理？',
                        showCancelButton: true,
                        confirmButtonText: '是',
                        cancelButtonText: `否`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            const dom = vm.$refs.form_edit;
                            dom.action = url;
                            dom.querySelector('input[name=status]').value = "已處理"
                            dom.querySelector('input[type=submit]').click()
                        }
                    })
                },
            }
        })
    </script>

@stop
