@extends('layouts.app')
@section('content')
<h2>Legg til ny Menu</h2>
<a href="{{ route('menus.index') }}" class="button">
    @icon('arrow-left')
    <span>Tilbake</span>
</a>

<form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @include('menus.form-fields')

    <button type="submit" class="button-success">
        <span>Opprett</span>
        @icon('save')
    </button>
</form>
@endsection
