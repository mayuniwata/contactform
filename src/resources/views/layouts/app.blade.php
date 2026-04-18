<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>FashionablyLate</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    @yield('css')
</head>
<body>

<header class="header">
    <h1 class="header__title">FashionablyLate</h1>

    @auth
        <form action="/logout" method="post">
            @csrf
            <button type="submit" class="header__btn">logout</button>
        </form>
    @else
        @if (request()->is('login'))
            <a href="/register" class="header__btn">register</a>
        @elseif (request()->is('register'))
            <a href="/login" class="header__btn">login</a>
        @elseif (
            request()->is('/') ||
            request()->is('confirm') ||
            request()->is('thanks')
        )
            
        @else
            <a href="/login" class="header__btn">login</a>
        @endif
    @endauth
</header>

<main>
    @yield('content')
</main>

</body>
</html>