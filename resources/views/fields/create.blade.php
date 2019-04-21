@extends('layouts.app')
@section('content')
    <h2>Legg til ny field</h2>
    <a href="{{ route('fields.index') }}" class="button">
        @icon('arrow-left')
        <span>Tilbake</span>
    </a>

    <form action="{{ route('fields.store') }}" method="POST">
        @csrf

        @include('fields.form-fields')

        <button type="submit" class="button-success">
            <span>Opprett</span>
            @icon('save')
        </button>
    </form>
@endsection
