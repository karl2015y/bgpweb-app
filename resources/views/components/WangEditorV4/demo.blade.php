@section('body')
    @parent
    <section id="demo">
         <div class="container flex gap-16 mx-auto px-5 py-8 sm:mt-0 sm:px-32"></div>
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
