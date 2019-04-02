@extends('layouts.app')
@section('content')
    <h2>Rediger field</h2>
    <a href="{{ route('fields.index') }}">← Tilbake</a>

    <form action="{{ route('fields.update', $field) }}" method="POST">
        @csrf
        @method('patch')

        @include('fields.form-fields')

        <button type="submit">Opprett</button>
    </form>
@endsection
