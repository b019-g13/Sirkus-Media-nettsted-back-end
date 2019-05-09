@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('user-plus')
                    <span>Registrer en ny bruker</span>
                </h1>
            </div>
            <div class="actions">
                <a href="{{ route('menu_locations.index') }}" class="button button-primary-alt">
                    @icon('arrow-left')
                    <span>Tilbake</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">{{ __('Phone') }}</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <label for="role">{{ __('Role') }}</label>
                    <select name="role" id="role">
                        @php
                            $old_value = old('role');
                        @endphp
                        @if ($old_value == null)
                            <option value="" hidden selected disabled>Velg en</option>
                        @endif
                        @foreach ($roles as $role)
                            @if ($old_value == $role->id)
                                <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                            @else
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-group-submit">
                    <span></span>
                    <button type="submit">
                        <span>{{ __('Register') }}</span>
                        @icon('arrow-right')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
