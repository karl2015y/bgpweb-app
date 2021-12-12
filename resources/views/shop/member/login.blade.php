@extends('shop.layouts.master')

@section('body')
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>

                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    查詢訂單
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    曾經在消費過的人客，只要輸入您的Email就可以查詢到所有訂單喔！
                </p>
            </div>
            @if ($email && $isRegistered)
                <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="rounded-md shadow-sm -space-y-px">

                        <div>
                            <label for="email-address" class="sr-only">Email 地址</label>
                            <input value="{{ old('email', $email) }}" id="email-address" name="email" type="email"
                                autocomplete="email" required
                                class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="購買時所留的Email address">
                        </div>
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Password">
                        </div>



                    </div>

                     {{-- <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if ($remember_me ?? false)
                                <input id="remember-me" name="remember-me" type="checkbox" checked
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            @else
                                <input id="remember-me" name="remember-me" type="checkbox"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            @endif
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                                Remember me
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Forgot your password?
                            </a>
                        </div>
                    </div>  --}}
              <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-550 hover:bg-gray-350 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <!-- Heroicon name: solid/lock-closed -->
                                <svg class="h-5 w-5 text-gray-350 group-hover:text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            登入
                        </button>
                    </div>
      
                </form>
            @else
                <form class="mt-8 space-y-6" action="" method="GET">
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div>
                            <label for="email-address" class="sr-only">Email 地址</label>
                            <input value="{{ $email ? $email : '' }}" id="email-address" name="email" type="email"
                                autocomplete="email" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="購買時所留的Email address">
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-550 hover:bg-gray-350 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <!-- Heroicon name: solid/lock-closed -->
                                <svg class="h-5 w-5 text-gray-350 group-hover:text-indigo-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            確認信箱
                        </button>
                    </div>
                </form>
            @endif


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
                openHasNotHistoryModal: function() {
                    Swal.fire({
                        icon: 'error',
                        title: '歡迎您的到來',
                        text: '我們並無查到該Email下有任何訂單紀錄，是不是還沒有消費過呢？歡迎到商城逛逛喔！如果Email沒問題，但還是找不到訂單，麻煩您通知我們的客服，我們會盡全力幫忙找尋訂單，不會損失您的任何權益',
                    })

                },
                openIsNotRegistered: function() {
                    Swal.fire({
                        icon: 'warning',
                        title: '歡迎您的到來',
                        text: '我們查到該Email下有確實有訂單紀錄，但是為了保障客戶隱私，我們必須跟您做個身分驗證。請您務必放心，這個過程只有一次並且不會花費您太多寶貴的時間，我們已經將驗證的資料寄送到您的Email({{ $email }})，請您查收。',
                    })
                },
            },
            created: function() {
                /*
                    @if ($email && !$isRegistered)*/
                        this.openIsNotRegistered()
                        /*@endif */
                /*
                @if ($email && !$hasHistory)*/
                    this.openHasNotHistoryModal()
                    /*@endif */




            },
        })
    </script>

@stop
