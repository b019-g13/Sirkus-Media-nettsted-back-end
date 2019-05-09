@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('mail')
                    <span>{{ _('Your email is now verified') }}</span>
                </h1>
            </div>
            <div class="actions">
                <a href="{{ route('home') }}" class="button button-primary-alt">
                    @icon('arrow-right')
                    <span>Gå videre</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            <p>{{ __('Your email was correctly verified') }}.</p>
        </div>
    </div>
@endsection