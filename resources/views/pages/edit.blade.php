@extends('layouts.app')
@section('content')
    <h2>Rediger page</h2>
    <a href="{{ route('pages.index') }}">← Tilbake</a>

    <form  id="form-page" action="{{ route('pages.update', $page) }}" method="POST">
        @csrf
        @method('patch')

        @include('pages.form-fields')

        <button type="submit">Oppdater</button>
    </form>

    <script src="{{ asset('js/page.js') }}"></script>
@endsection
