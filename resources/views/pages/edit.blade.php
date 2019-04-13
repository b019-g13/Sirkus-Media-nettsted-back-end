@extends('layouts.app')
@section('content')
    <h2>
        @icon('edit')
        <span>Rediger page</span>
    </h2>
    <a href="{{ route('pages.index') }}" class="button">
        @icon('arrow-left')
        <span>Tilbake</span>
    </a>

    <form  id="form-page" action="{{ route('pages.update', $page) }}" method="POST">
        @csrf
        @method('patch')

        @include('pages.form-fields')

        <button type="submit">
            <span>Oppdater</span>
            @icon('save')
        </button>
    </form>

    <script src="{{ asset('js/page.js') }}" defer></script>
@endsection
