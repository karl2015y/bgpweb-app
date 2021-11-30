@extends('shop.layouts.master')

@section('body')
    <div class="bg-grey-lighter flex flex-col max-h-96 my-8 sm:mt-12">
        <div class="container max-w-sm mx-auto flex-1 flex flex-col items-center justify-center px-2">
            <div class="bg-white border-gray-50 border-solid p-6 rounded sm:border sm:shadow-md text-black w-full">
                <h1 class="mb-8 text-3xl text-center">填寫密碼，後續就不需再次驗證</h1>

                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <input value="{{ old('email', $email ?? '') }}" type="text"
                        class="block border border-grey-light w-full p-3 rounded mb-4" name="email"
                        placeholder="Email電子信箱(帳號)" />

                         <input value="{{ old('name') }}" type="text"
                        class="block border border-grey-light w-full p-3 rounded mb-4" name="email"
                        placeholder="Instagram帳號(IG)" />

                    <input type="password" class="block border border-grey-light w-full p-3 rounded mb-4" name="password"
                        placeholder="請設定查詢訂單時的密碼" />
                    <input type="password" class="block border border-grey-light w-full p-3 rounded mb-4"
                        name="password_confirmation" placeholder="確認密碼" />

                    <button type="submit"
                        class="bg-gray-550 focus:outline-none hover:-translate-y-0.5 hover:shadow-lg my-1 py-3 text-center text-white transform w-full">確定送出</button>
                </form>


                <div class="text-center text-sm text-gray-350 mt-4">
                    送出前,
                    請先確定是否已經了解我們的<br>
                    <a class="underline border-b border-grey-dark text-gray-350" href="#" v-on:click="openIframe('/servicepolicy')">
                        服務條款
                    </a> 與
                    <a class="underline border-b border-grey-dark text-gray-350" href="#" v-on:click="openIframe('/privacy-policy')">
                        隱私權條款
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop


@section('JS-content')
    @parent

    <script type="text/javascript">
        mixins.push({
            data: function() {
                return {};
            },
            methods: {
                openIframe: function(url) {
                    Swal.fire({
                        html: `<iframe class="w-full" style="height: calc(100vh - 260px);" src="${url}"></iframe>`,
                        showCancelButton: false,
                        confirmButtonText: '關閉',
                        confirmButtonColor: '#5B5B5B',
                    })
                }
            },
            created: function() {




            },
        })
    </script>

@stop
