<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload and edit images in Laravel using Croppic jQuery plugin</title>
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
        }

    </style>

</head>

<body style="height: 100vh;">
    <link rel="stylesheet" href="/plugins/croppic/css/main.css" />
    <link rel="stylesheet" href="/plugins/croppic/css/croppic.css" />
    <div id="cropContainerEyecandy">
    </div>

    <script src="/plugins/croppic/js/jquery-2.1.3.min.js"></script>
    <script src="/plugins/croppic/js/croppic.min.js"></script>
    <script>
        const path = '{{ $path }}';
        const filename = '{{ $filename ?? 'ok.jpg' }}';
        const domId = 'cropContainerEyecandy'
        var eyeCandy = $(`#${domId}`);
        eyeCandy.width('{{ $w }}');
        eyeCandy.height('{{ $h }}');
        var croppedOptions = {
            modal: true,
            onAfterImgCrop: function() {
                eyeCandy.append(
                    `<input type="hidden" name="${filename}" value="${eyeCandy.children('img').attr("src")}" />`
                );
                alert('上傳成功！')
                /*
                @if ($back_url)*/
                    window.location.href='{{ $back_url }}';
                    /*@endif*/
            },
            rotateControls: false,
            /*
            @if (!isset($filename))*/
                loadPicture: "{{ url($path) . '?t=' . rand() }}",
                /*@endif*/
            uploadUrl: '{{ route('picupload') }}',
            uploadData: {
                path,
                filename
            },
            cropUrl: '{{ route('piccrop') }}',
            cropData: {
                'width': eyeCandy.width(),
                'height': eyeCandy.height()
            }
        };
        var cropperBox = new Croppic(domId, croppedOptions);
    </script>
</body>

</html>
