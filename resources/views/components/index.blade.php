{{-- @extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2> Komponenter </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('components.create') }}"> Oprett ny komponent </a>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>Navn</th>
            <th>Slug</th>
            <th>Forelder</th>
            <th>Handling</th>
        </tr>
        @foreach ($components as $component)
        <tr>
            <td>{{ $component->name }}</td>
            <td>{{ $component->slug }}</td>
            <td>{{ $component->parent ? $component->parent->name : null }}</td>
            <td>
                <form action="{{ route('components.destroy' , $component->id) }}" method="POST" enctype="multipart/form-data">
                     @csrf

                    <a class="btn btn-info" href="{{ route('components.show',$component->id) }}"> Vis </a>

                    <a class="btn btn-primary" href="{{ route('components.edit',$component->id) }}"> Rediger </a>

                    @method('DELETE')

                    <button type="submit" class="btn btn-danger"  onclick="return confirm('Er du sikkert å slette det?')"> Slett </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $components->onEachSide(1)->links() }}
@endsection --}}


@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('package')
                    <span>Komponenter</span>
                </h1>
                <p>Oversikt over alle komponenter.</p>
            </div>
            <div class="actions">
                <a href="{{ route('components.create') }}" class="button button-primary-alt">
                    @icon('plus-square')
                    <span>Ny komponent</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            @if (!$components->onFirstPage())
                <p>Side {{ $components->currentPage() }}</p>
            @endif
            <table class="first-bold">
                <thead>
                    <tr>
                        <th>Navn</th>
                        <th class="auto-hide">Slug</th>
                        <th>Forelder</th>
                        <th class="auto-hide">Sist redigert</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($components as $component)
                        <tr>
                            <td>{{ $component->name }}</td>
                            <td class="auto-hide">{{ $component->slug }}</td>
                            <td>{{ $component->parent ? $component->parent->name : null }}</td>
                            <td class="auto-hide" title="{{ $component->created_at->diffForHumans() }}">{{ $component->created_at->format('d-m-Y') }}</td>
                            <td>
                                <div>
                                    <a class="button button-success button-action" href="{{ route('components.edit', $component) }}">
                                        @icon('edit')
                                    </a>
                                    <form action="{{ route('components.destroy', $component) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button-error button-action"  onclick="return confirm('Er du sikker på at du vil slette komponenten?')">@icon('trash')</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @include('partials.nav-pagination', ['pagination_items' => $components])
        </div>
    </div>
@endsection
