@extends('layouts.app')
@section('content')
    <h2>Legg til ny Link</h2>

    <a href="{{ route('links.index') }}" class="button">
        @icon('arrow-left')
        <span>Tilbake</span>
    </a>

    <form action="{{ route('links.store') }}" method="POST">
        @csrf

        @include('links.form-fields')

        <button type="submit" class="button-success">
            <span>Opprett</span>
            @icon('save')
        </button>
    </form>
@endsection
