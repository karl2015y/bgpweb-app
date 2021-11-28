    {{ $productItems->links() }}



    <div class="my-2">

        {{-- title --}}
        <div
            class="hidden  lg:flex justify-around bg-white shadow-sm py-2 font-bold rounded border border-solid border-gray-100">
            <div class="border-r border-solid w-full text-center border-gray-200">品項名稱/數量</div>
            <div class="border-r border-solid w-full text-center border-gray-200">品項圖片</div>
            <div class="border-r border-solid w-full text-center border-gray-200">品項價錢</div>
            <div class="border-r border-solid w-full text-center border-gray-200">操作</div>
        </div>
        @forelse  ($productItems as $item)
            {{-- content start --}}
            <div
                class="px-5 lg:px-0 mt-2 lg:mt-1 block  lg:flex justify-around bg-white shadow lg:shadow-sm hover:shadow-2xl py-6 lg:py-2 rounded border border-solid border-gray-100">


                {{-- 品項名稱 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">品項名稱/數量</div>
                        <div class=" flex justify-center text-gray-350">
                            <span class="text-sm">{{ $item->name }} (庫存：{{ $item->count }})</span>
                            
                        </div>
                    </div>
                </div>

                {{-- 品項圖片 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">品項圖片</div>
                        <div class=" flex justify-center text-gray-350">
                            <div class="h-auto w-40">
                                @if ($item->img_url)
                                    <img class="w-full h-full" src="{{ $item->img_url }}"
                                        alt="{{ $item->name }}">
                                @else
                                    <span>無圖片</span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                {{-- 品項價錢 --}}
                <div
                    class="border-b pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="lg:hidden font-bold whitespace-nowrap">品項價錢</div>
                        <div class=" flex justify-center text-gray-350 flex-col items-end sm:items-center">
                                @if ($item->org_price != $item->sell_price)
                                    <span class="font-bold block title-font font-medium text-red-600">限時特價：NTD
                                        {{ $item->sell_price }}
                                    </span>
                                    <span class="line-through title-font font-medium text-sm text-gray-350">原價：NTD
                                        {{ $item->org_price }}</span>
                                @else
                                    <span class="font-bold block title-font font-medium text-gray-900">建議售價：NTD
                                        {{ $item->sell_price }}</span>
                                @endif


                        </div>
                    </div>
                </div>

                <div
                    class="pb-2 mb-3 lg:pb-0 lg:mb-0 lg:border-b-0 lg:border-r border-solid w-full text-center border-gray-200 ">
                    <div class="flex justify-between lg:block mt-1.5">
                        <div class="text-gray-350  w-full">
                            <a href="{{ route('admin_product_item.editPic', $item->id) }}">
                                <button class="btn btn-main btn-rwd btn-sm  text-sm">編輯品項圖片</button>
                            </a>
                            <a href="{{ route('admin_product_item.edit', $item->id) }}">
                                <button class="btn btn-sec btn-rwd btn-sm  text-sm">編輯品項</button>
                            </a>
                          



                        </div>
                    </div>


                </div>


            </div>
            {{-- content end --}}
        @empty
            <div class="border-solid border-gray-100 border rounded p-5 bg-white text-center mt-2 shadow-sm">目前沒有資料喔
            </div>
        @endforelse
    </div>


    {{ $productItems->links() }}
