@extends('layouts.app')
@section('content')
    <h2>
        @icon('plus-square')
        <span>Legg til ny Page</span>
    </h2>

    <a href="{{ route('pages.index') }}" class="button">
        @icon('arrow-left')
        <span>Tilbake</span>
    </a>

    <form id="form-page" action="{{ route('pages.store') }}" method="POST">
        @csrf

        @include('pages.form-fields')

        <button type="submit" class="button-success">
            <span>Opprett</span>
            @icon('save')
        </button>
    </form>

    @include('links.pick-modal')

    <script src="{{ asset('js/page.js') }}" defer></script>
@endsection
