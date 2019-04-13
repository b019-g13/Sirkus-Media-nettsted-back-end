@extends('layouts.app')
@section('content')
    <h1>Rediger komponent</h1>

    <a href="{{ route('components.index') }}">
        <span>&#8592;</span>
        <span>Tilbake</span>
    </a>

    <form id="form-components" action="{{ route('components.update', $component) }}" method="POST">
        @csrf
        @method('PATCH')
        @include('components.form-fields')

        <div class="form-group">
            <button type="submit">
                <span>Oppdater</span>
                @icon('save')
            </button>
        </div>
    </form>

    <script src="{{ asset('js/component.js') }}" defer></script>
@endsection
