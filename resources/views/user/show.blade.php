@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    <img src="{{ $user->image->url_full }}" alt="{{ $user->image->attribute_alt }}">
                    <span>{{ __('User') }} — {{ $user->name }}</span>
                </h1>
                <p>Rediger din bruker.</p>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">

            <form action="{{ route('user.update') }}" method="post" enctype=multipart/form-data>
                {{ csrf_field() }}
            
                <fieldset>
                    <legend>{{ __('User info') }}</legend>
                    <div class="form-group">
                        <label for="user-update-form-name">{{ __('Name') }}</label>
                        <input id="user-update-form-name" type="text" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user-update-form-email">{{ __('Email') }}</label>
                        <input id="user-update-form-email" type="email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user-update-form-image">{{ __('Image') }}</label>
                        <input id="user-update-form-image" type="file" name="image" value="{{ old('image') }}">
                    </div>
                    <div class="form-group form-group-checkbox">
                        @if ($user->image_id !== null)
                            <label for="user-update-form-image-remove">{{ __('Remove current image') }}</label>
                            <input id="user-update-form-image-remove" type="checkbox" name="image_remove">
                        @endif
                    </div>
                </fieldset>
                <fieldset>
                    <legend>{{ __('Change password') }}</legend>
                    <div class="form-group">
                        <label for="user-update-form-password">{{ __('New password') }}</label>
                        <input id="user-update-form-password" type="password" name="new_password">
                    </div>
                    <div class="form-group">
                        <label for="user-update-form-password-confirm">{{ __('Confirm new password') }}</label>
                        <input id="user-update-form-password-confirm" type="password" name="new_password_confirmation">
                    </div>
                </fieldset>
                <fieldset class="hide">
                    <legend>{{ __('Confirm your identity') }}</legend>
                    <p>{{ __('In order to save your changes, we need you to confirm your identity by writing your current password.') }}</p>
            
                    <div class="form-group">
                        <label for="user-update-form-password-current">{{ __('Current password') }}</label>
                        <input id="user-update-form-password-current" type="password" name="current_password">
                    </div>
                </fieldset>
                <div class="form-group form-group-submit">
                    <span></span>
                    <button type="submit">
                        <span>{{ __('Save') }}</span>
                        @icon('save')
                    </button>
                </div>
            </form>

        </div>
    </div>
    <script src="{{ asset('js/user.js') }}"></script>
@endsection