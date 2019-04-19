@extends('layouts.app')
@section('content')
    <h2>Rediger field</h2>
    <a href="{{ route('fields.index') }}" class="button">
        @icon('arrow-left')
        <span>Tilbake</span>
    </a>

    <form action="{{ route('fields.update', $field) }}" method="POST">
        @csrf
        @method('patch')

        @include('fields.form-fields')

        <button type="submit" class="button-success">
            <span>Oppdater</span>
            @icon('save')
        </button>
    </form>
@endsection
