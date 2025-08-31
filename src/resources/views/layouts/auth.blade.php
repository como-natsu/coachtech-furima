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
        </div>
    </header>

    <div class="content">
        @yield('content')
    </div>
</body>

</html>