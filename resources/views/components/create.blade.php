@extends('layouts.app')
@section('content')
    <h1>Legg til ny komponent</h1>

    <a href="{{ route('components.index') }}">
        <span>&#8592;</span>
        <span>Tilbake</span>
    </a>

    <form id="form-components" action="{{ route('components.store') }}" method="POST">
        @csrf
        @include('components.form-fields')

        <div class="form-group">
            <button type="submit">Opprett</button>
        </div>
    </form>

    <script src="{{ asset('js/component.js') }}"></script>
@endsection
