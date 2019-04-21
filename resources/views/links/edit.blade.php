@extends('layouts.app')
@section('content')
    <h2>Rediger Linken</h2>

    <a href="{{ route('links.index') }}" class="button">
        @icon('arrow-left')
        <span>Tilbake</span>
    </a>

    <form action="{{ route('links.update', $link) }}" method="POST">
        @csrf
        @method('PATCH')

        @include('links.form-fields')

        <button type="submit" class="button-success">
            <span>Oppdater</span>
            @icon('save')
        </button>
    </form>
@endsection
