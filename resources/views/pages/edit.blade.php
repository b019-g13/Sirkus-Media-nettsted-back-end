@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('edit')
                    <span>Rediger side: {{ $page->title }}</span>
                </h1>
            </div>
            <div class="actions">
                <a href="{{ route('pages.index') }}" class="button button-primary-alt">
                    @icon('arrow-left')
                    <span>Tilbake</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            <form id="form-page" action="{{ route('pages.update', $page) }}" method="POST">
                @csrf
                @method('patch')
                @include('pages.form-fields')
        
                <div class="form-group form-group-submit">
                    <span></span>
                    <button type="submit">
                        <span>Oppdater</span>
                        @icon('save')
                    </button>
                </div>
            </form>
        
            @include('components.pick-modal')
            @include('links.pick-modal')
        </div>
    </div>
    <script src="{{ asset('js/page.js') }}" defer></script>
@endsection
