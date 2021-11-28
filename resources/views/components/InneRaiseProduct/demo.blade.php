@section('body')
    @parent
    <section id="demo">
        <div class="container flex gap-16 mx-auto px-5 py-8 sm:mt-0 sm:px-32">

            <div class="w-full lg:w-7/12">

                <img wh-ratio="1.5" class="w-full" src="//cdn.shopify.com/s/files/1/0564/3331/1912/products/DSC07531_1_300x300.jpg?v=1621266659">

            </div>
            <div class="w-full lg:w-5/12 gap-5 flex flex-col items-center justify-around">
                <h1 class="text-gray-550 text-3xl font-bold">inneRaise 素燃錠</h1>
                <span>$1,680</span>
                <p class="whitespace-pre-line text-gray-350">常常到一個心動的保健品，準備剁手下單的同時，看成分卻發現竟然有動物性原料成分嗎？為了提供素食者更多保健品選擇，inneRaise的產品皆不使用動物性原料、素食可食。同時，我們也</p>
                <a class="text-gray-550" href="#">完整資訊 →</a>
            </div>

        </div>
    </section>


@stop



@section('JS-content')
    @parent
    <script type="text/javascript">
        mixins.push({
            mounted: () => {
                document.querySelector('footer').remove();
                document.querySelector('header').remove();
            }

        })
    </script>
@stop
