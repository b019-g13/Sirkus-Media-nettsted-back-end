@extends('layouts.app')
@section('content')
    <h2>Legg til ny field</h2>
    <a href="{{ route('fields.index') }}">← Tilbake</a>

    <form action="{{ route('fields.store') }}" method="POST">
        @csrf

        @include('fields.form-fields')

        <button type="submit">Opprett</button>
    </form>
@endsection
