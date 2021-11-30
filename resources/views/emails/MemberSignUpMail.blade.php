<!DOCTYPE html>
<html>

<head>
    <title>DearMe身分驗證信</title>
</head>

<body>
    <p>
        親愛的貴賓您好：<br>
        我們查到該Email下有確實有訂單紀錄，但是我們很注重您的隱私，我們必須跟您做個身分驗證。
        請您務必放心，這個過程只有一次，並且不會花費您太多寶貴的時間。
    </p>

    <p>
        <a href="{{ $details['link'] }}">點擊此處驗證</a>
    </p>
    <p>
        若連結進不去可以複製以下連結<br>
        {{ $details['link'] }}
    </p>

    <p>
        DearMe 全體敬上
    </p>
</body>

</html>
