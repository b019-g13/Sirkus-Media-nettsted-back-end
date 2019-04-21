<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <nav id="nav-main">
        <a href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        @auth
            <ul>
                <li><a href="{{ route('pages.index') }}">Pages</a></li>
                <li><a href="{{ route('menus.index') }}">Menus</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            </ul>
            <ul>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        @endauth
        @guest
            <ul>
                <li>
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            </ul>
        @endguest
    </nav>

    @include('messages.flash-message')

    <main>
        @yield('content')
    </main>

    <footer id="footer-main">
        @role('superadmin')
            <strong>Superadmin</strong>
            <ul>
                <li><a href="{{ route('components.index') }}">Components</a> </li>
                <li><a href="{{ route('fields.index') }}">Fields</a></li>
                <li><a href="{{ route('menu_locations.index') }}">Menu locations</a></li>
            </ul>
        @endrole
    </footer>
</body>
</html>
