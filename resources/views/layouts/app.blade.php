<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/home.css')}}" rel="stylesheet"/>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/home">COUNTER-<span class="fakeSpan">FAKE</span></a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/media-rank">Ranking rzetelności<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/about">O stronie</a>
        </li>
        @auth
          <li class="nav-item">
              <form method="POST" action="{{route('logout')}}">@csrf
              <input type="submit" value="Wyloguj"/>
              </form>
          </li>
        @endauth
        @guest
            <li class="nav-item">
                <a class="nav-link" href="/login">Logowanie</a>
            </li>
            <li>
                <a class="nav-link" href="/register">Rejestracja</a>
            </li>
        @endguest
        </ul>
        <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Szukaj" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Szukaj</button>
        </form>
        </div>
    </nav>

        <main class="py-4">
            @yield('content')
        </main>
          <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
          <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
