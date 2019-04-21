@extends('layouts.app')
@section('content')
    <h2>Legg til ny Menu</h2>
    <a href="{{ route('menus.index') }}" class="button">
        @icon('arrow-left')
        <span>Tilbake</span>
    </a>

    <form id="form-menu" action="{{ route('menus.store') }}" method="POST">
        @csrf

        @include('menus.form-fields')

        <button type="submit" class="button-success">
            <span>Opprett</span>
            @icon('save')
        </button>
    </form>

    @include('links.create-modal')
    @include('links.edit-modal')
    @include('links.delete-modal')

    <script src="{{ asset('js/menu.js') }}" defer></script>
@endsection
