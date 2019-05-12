<footer id="footer-main">
    <div id="footer-main-wrapper">
        @guest
            <div class="footer-menu">
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
            </div>
        @endguest
        @auth
            <div class="footer-menu">
                <a href="{{ route('user.show') }}">{{ __('Profile') }}</a>
                @role('superadmin|admin|moderator')
                    <a href="{{ route('pages.index') }}">{{ __('Pages') }}</a>
                    <a href="{{ route('menus.index') }}">{{ __('Menus') }}</a>
                @endrole
                @role('superadmin|admin')
                    <a href="{{ route('user.index') }}">{{ __('Users') }}</a>
                    <a href="{{ route('site_settings.index') }}">{{ __('Settings') }}</a>
                @endrole
            </div>
            @role('superadmin')
                <div class="footer-menu">
                    <p><strong>Superadmin</strong></p>
                    <a href="{{ route('components.index') }}">Components</a>
                    <a href="{{ route('fields.index') }}">Fields</a>
                    <a href="{{ route('menu_locations.index') }}">Menu locations</a>
                </div>
            @endrole
        @endauth
        <p class="copyright">
            <span>{{ __('A project by') }}</span>
            <a href="https://b019-g13.group/" noopener noreferrer target="_blank">B019-G13</a>
        </p>
    </div>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,700" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700" rel="stylesheet"/>
    <script src="{{ asset('js/app.js') }}"></script>
</footer>
