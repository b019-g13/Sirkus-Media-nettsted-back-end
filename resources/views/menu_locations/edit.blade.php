@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('file-plus')
                    <span>Rediger meny plassering: {{ $menu_location->name }}</span>
                </h1>
            </div>
            <div class="actions">
                <a href="{{ route('menu_locations.index') }}" class="button button-primary-alt">
                    @icon('arrow-left')
                    <span>Tilbake</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            <form id="form-menu_locations" action="{{ route('menu_locations.update', $menu_location) }}" method="POST">
                @csrf
                @method('patch')
                @include('menu_locations.form-fields')
        
                <div class="form-group form-group-submit">
                    <span></span>
                    <button type="submit">
                        <span>Oppdater</span>
                        @icon('save')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


