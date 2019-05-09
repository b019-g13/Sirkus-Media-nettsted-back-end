@extends('partials.master')

@section('content')
<div class="padded">
    <h1>{{ __('Your email is now verified') }}</h1>

    <div>
        <p>{{ __('Your email was correctly verified') }}.</p>
        <p>{{ __('Continue to') }} <a href="{{ route('home') }}">{{ __('dashboard') }}</a>.</p>
    </div>
</div>
@endsection
