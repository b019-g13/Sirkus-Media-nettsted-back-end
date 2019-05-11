@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('file-plus')
                    <span>Rediger komponent: {{ $component->name }}</span>
                </h1>
            </div>
            <div class="actions">
                <a href="{{ route('components.index') }}" class="button button-primary-alt">
                    @icon('arrow-left')
                    <span>Tilbake</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            <form id="form-components" action="{{ route('components.update', $component) }}" method="POST">
                @csrf
                @method('patch')
                @include('components.form-fields')
        
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
    <script src="{{ asset('js/component.js') }}" defer></script>
@endsection

