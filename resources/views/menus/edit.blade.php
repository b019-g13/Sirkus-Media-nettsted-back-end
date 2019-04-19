@extends('layouts.app')
@section('content')
    <h2>Rediger Menu</h2>
    <a href="{{ route('menus.index') }}" class="button">
        @icon('arrow-left')
        <span>Tilbake</span>
    </a>

    <form action="{{ route('menus.update', $menu->id) }}" method="POST">
        @csrf
        @method('patch')

        @include('menus.form-fields')

        <button type="submit" class="button-success">
            <span>Oppdater</span>
            @icon('save')
        </button>
    </form>
@endsection
