@php
$cart_datas = (new app\Http\Controllers\CartController())->getCartDatas();
@endphp
<div v-on:click="cartOpen = !cartOpen" v-if="cartOpen"
    class="fixed bg-black bg-opacity-40 h-screen top-0 w-screen z-20">
</div>
<div :class="cartOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'"
    class="z-20 fixed right-0 top-0 max-w-xs w-full h-full px-6 py-4 transition duration-300 transform overflow-y-auto bg-white border-l-2 border-gray-300">
    <div class="flex items-center justify-between">
        <h3 class="text-2xl font-medium text-gray-700">購物車</h3>
        <button @click.stop="cartOpen = !cartOpen" class="text-gray-600 focus:outline-none">
            <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                viewBox="0 0 24 24" stroke="currentColor">
                <path d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>


    @if ($cart_datas)
        @forelse ($cart_datas->items as $item)
            <div class="flex justify-between my-3 py-3 border-solid border-t border-gray-300">
                <div class="flex">
                    <div class="mx-3">
                        <h3 class="text-sm text-gray-600">{{ $item->product_item_name }}</h3>
                        <div class="flex items-center mt-2">
                            <a class="flex items-center"
                                href="{{ route('lessProductItemCountFromOrder', ['order_item_id' => $item->id]) }}">
                                <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </a>
                            <span class="text-gray-700 mx-2">{{ $item->count }}</span>

                            <a class="flex items-center"
                                href="{{ route('addProductItemCountFromOrder', ['order_item_id' => $item->id]) }}">
                                <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-between items-end">
                    <span class="text-gray-600">NTD {{ $item->product_item_price }}</span>

                    <button
                        v-on:click="removeOrderItemFromCart({{ $item->id }}, '{{ $item->product_item_name }}')"
                        class="text-red-400 focus:outline-none focus:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <p>購物車目前為空，去逛逛再回來吧~</p>
        @endforelse
    @else
        <p>購物車目前為空，去逛逛再回來吧~</p>
    @endif

    @if ($cart_datas && count($cart_datas->items) != 0)
        <a href="{{ route('checkoutPage') }}"
            class="flex items-center justify-center mt-4 px-3 py-2 bg-blue-600 text-white text-sm uppercase font-medium rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
            <span>前往結帳</span>
            <svg class="h-5 w-5 mx-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                viewBox="0 0 24 24" stroke="currentColor">
                <path d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
        </a>
    @endif
</div>


@section('JS-content')
    @parent
    <script type="text/javascript">
        mixins.push({

            data: function() {
                return {
                    cartOpen: false,
                }
            },
            methods: {

                removeOrderItemFromCart: function(product_item_id, name = '') {
                    Swal.fire({
                        title: `是否刪除${name}`,
                        showDenyButton: true,
                        confirmButtonText: '是',
                        denyButtonText: `取消`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            document.location.href =
                                `{{ route('removeProductItemFromOrder') }}?order_item_id=${product_item_id}`;
                        } else if (result.isDenied) {
                            Swal.fire('已取消', '', 'info')
                        }
                    })

                },

            },
            created: function() {
                /* 
                @if (session('open_control_div'))*/
                    this.cartOpen = true;
                    /* @endif */
            }
        })
    </script>

@stop
