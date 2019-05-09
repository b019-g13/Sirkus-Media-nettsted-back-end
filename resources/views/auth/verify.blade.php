@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('mail')
                    <span>{{ _('Verify Your Email Address') }}</span>
                </h1>
            </div>
            <div class="actions">
                <a href="{{ route('verification.resend') }}" class="button button-primary-alt">
                    <span>Send link på nytt</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            @if (session('resent'))
                <p>{{ __('A fresh verification link has been sent to your email address.') }}</p>
            @endif
    
            <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
        </div>
    </div>
@endsection