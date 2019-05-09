@extends('partials.master')

@section('content')
<div class="padded">
    <h1>{{ __('Register') }}</h1>
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
            <button type="submit">
                <span>{{ __('Register') }}</span>
                @icon('arrow-right')
            </button>
        </div>
    </form>
</div>
@endsection
