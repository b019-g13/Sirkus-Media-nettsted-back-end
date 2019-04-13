@extends('layouts.app')
@section('content')
    <h2>Legg til ny Page</h2>
    <a href="{{ route('pages.index') }}">← Tilbake</a>

    <form id="form-page" action="{{ route('pages.store') }}" method="POST">
        @csrf

        @include('pages.form-fields')

        <button type="submit">Opprett</button>
    </form>

    <script src="{{ asset('js/page.js') }}" defer></script>
@endsection
