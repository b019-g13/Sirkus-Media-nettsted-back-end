@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('user')
                    <span>{{ _('Login') }}</span>
                </h1>
            </div>
            @if (Route::has('password.request'))
                <div class="actions">
                    <a href="{{ route('password.request') }}" class="button button-primary-alt">
                        <span>{{ __("Forgot Your Password?") }}</span>
                    </a>
                </div>
            @endif
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">
                        {{ __("E-Mail Address") }}
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    />
                </div>

                <div class="form-group">
                    <label for="password">
                        {{ __("Password") }}
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                    />
                </div>

                <div class="form-group form-group-checkbox">
                    <input type="checkbox" name="remember" id="remember" {{ old("remember") ? "checked" : "" }}>
                    <label for="remember">
                        {{ __("Remember Me") }}
                    </label>
                </div>

                <div class="form-group form-group-submit">
                    <span></span>
                    <button type="submit">
                        <span>{{ __('Login') }}</span>
                        @icon('arrow-right')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection