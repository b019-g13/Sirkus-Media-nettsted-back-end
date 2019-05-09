<footer id="footer-main">
    <div id="footer-main-wrapper">
        <p>
            @guest
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                @if (Route::has('register'))
                    <span>|</span>
                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            @endguest
            @auth
                <a href="{{ route('user.show') }}">{{ __('Profile') }}</a>
                <span>|</span>
                <a href="{{ route('pages.index') }}">{{ __('Pages') }}</a>
                <span>|</span>
                <a href="{{ route('menus.index') }}">{{ __('Menus') }}</a>
                <span>|</span>
                <a href="{{ route('user.index') }}">{{ __('Users') }}</a>
                @role('superadmin')
                    <div>
                        <strong>Superadmin</strong>
                        <span>|</span>
                        <a href="{{ route('components.index') }}">Components</a>
                        <span>|</span>
                        <a href="{{ route('fields.index') }}">Fields</a>
                        <span>|</span>
                        <a href="{{ route('menu_locations.index') }}">Menu locations</a>
                    </div>
                @endrole
            @endauth
        </p>
        <p class="copyright">
            <span>{{ __('A project by') }}</span>
            <a href="https://b019-g13.group/" noopener noreferrer target="_blank">B019-G13</a>
        </p>
    </div>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet"> 
    <script src="{{ asset('js/app.js') }}"></script>
</footer>
