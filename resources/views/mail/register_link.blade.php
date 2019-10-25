<style>
    .hint {
        color: gray;
    }

    a {
        color: black;
    }
</style>
<body>
    <div>
        <p>Для завершеня регистрации в системе перейдите по <a href="{{ $link }}"><strong>ссылке</strong></a> и заполните форму</p>
        <a href="{{ $link }}"><i>{{ $link }}</i></a>
    </div>
    <br>
    <p class="hint">
        Данное письмо не требует ответа.
    </p>
</body>
