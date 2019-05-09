@extends('partials.master')

@section('content')
<div class="padded">
    <h1>{{ __("Login") }}</h1>
    <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

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
            <button type="submit">
                <span>{{ __('Login') }}</span>
                @icon('arrow-right')
            </button>
        </div>

        <div class="form-group">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __("Forgot Your Password?") }}
                </a>
            @endif
        </div>
    </form>
</div>
@endsection
