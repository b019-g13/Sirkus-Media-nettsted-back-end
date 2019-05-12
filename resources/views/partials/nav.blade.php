<nav id="nav-main">
    <div id="nav-main-wrapper">
        <div class="nav-left">
            <a class="nav-logo" href="{{ route('home') }}">
                <img class="logo" src="{{ asset('/images/sirkus-media-logo.svg') }}" alt="{{ config('app.name') }} logo">
                <img class="icon" src="{{ asset('/images/sirkus-media-icon.svg') }}" alt="{{ config('app.name') }} ikon">
            </a>
        </div>
        @guest
            <div class="nav-right">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </div>
        @endguest
        @auth
            <div class="nav-right">
                @role('superadmin|admin|moderator')
                    <a class="nav-link" href="{{ route('pages.index') }}">{{ __('Pages') }}</a>
                    <a class="nav-link" href="{{ route('menus.index') }}">{{ __('Menus') }}</a>
                @endrole
                @role('superadmin|admin')
                    <a class="nav-link" href="{{ route('user.index') }}">{{ __('Users') }}</a>
                    <a class="nav-link" href="{{ route('site_settings.index') }}">@icon('settings')</a>
                @endrole
                @php
                    $nav_user = Auth::user();
                @endphp
                <nav class="dropdown user-dropdown">
                    <div class="dropdown-trigger">
                        <img src="{{ $nav_user->image->url_full }}" alt="{{ __(':name profile picture', ['name' => $nav_user->name]) }}">
                        @icon('more-vertical', 'opened')
                        @icon('x', 'closed')
                    </div>
                    <div class="dropdown-content">
                        <span class="dropdown-content-title">{{ $nav_user->name }}</span>
                        <a href="{{ route('user.show') }}">Rediger konto</a>
                        <a
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        >
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </nav>
            </div>
        @endauth
    </div>
</nav>