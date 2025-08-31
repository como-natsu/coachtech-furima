<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coachtech frima</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/common.css')}}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header-inner">
            <a class="header-logo" href="/">
                <img class="header-logo-img" src="{{ asset('storage/logo/logo.svg') }}" alt="coachtech-logo">
            </a>
            <div class="header-right">
                <form class="header-search" action="/" method="GET">
                    <input class="header-search-input" type="text" name="search" placeholder="なにをお探しですか？">
                    <button class="header-search-button" type="submit">検索</button>
                </form>
                <nav class="header-nav">
                    <ul class="header-nav-list">
                        @guest
                        <li class="header-nav-item">
                            <a class="header-nav-link" href="/login">ログイン</a>
                        </li>
                        @else
                        <li class="header-nav-item">
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="header-nav-link">ログアウト</button>
                            </form>
                        </li>
                        @endguest
                        <li class="header-nav-item">
                            <a class="header-nav-link" href="/mypage">マイページ</a>
                        </li>
                        <li class="header-nav-item">
                            <a class="header-nav-link header-nav-link--sell" href="/sell">出品</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="content">
        @yield('content')
    </div>
</body>

</html>