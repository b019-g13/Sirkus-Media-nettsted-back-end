@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('plus-square')
                    <span>Legg til ny meny</span>
                </h1>
            </div>
            <div class="actions">
                <a href="{{ route('menus.index') }}" class="button button-primary-alt">
                    @icon('arrow-left')
                    <span>Tilbake</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            <form id="form-menu" action="{{ route('menus.store') }}" method="POST">
                @csrf
                @include('menus.form-fields')
        
                <div class="form-group form-group-submit">
                    <span></span>
                    <button type="submit">
                        <span>Opprett</span>
                        @icon('save')
                    </button>
                </div>
            </form>

            @include('links.create-modal')
            @include('links.edit-modal')
            @include('links.delete-modal')
        </div>
    </div>
    <script src="{{ asset('js/menu.js') }}" defer></script>
@endsection
