@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('file-plus')
                    <span>Rediger felt: {{ $field->name }}</span>
                </h1>
            </div>
            <div class="actions">
                <a href="{{ route('fields.index') }}" class="button button-primary-alt">
                    @icon('arrow-left')
                    <span>Tilbake</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            <form action="{{ route('fields.update', $field) }}" method="POST">
                @csrf
                @method('patch')
                @include('fields.form-fields')
        
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


