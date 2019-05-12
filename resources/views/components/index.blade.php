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
                <p>{{ __('Page') }} {{ $components->currentPage() }}</p>
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
