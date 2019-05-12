@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('list')
                    <span>Meny plasseringer</span>
                </h1>
                <p>Oversikt over alle meny plasseringer.</p>
            </div>
            <div class="actions">
                <a href="{{ route('menu_locations.create') }}" class="button button-primary-alt">
                    @icon('plus-square')
                    <span>Ny meny plassering</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            @if (!$menu_locations->onFirstPage())
                <p>{{ __('Page') }} {{ $menu_locations->currentPage() }}</p>
            @endif
            <table class="first-bold">
                <thead>
                    <tr>
                        <th>Navn</th>
                        <th>Slug</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menu_locations as $menu_location)
                        <tr>
                            <td>{{ $menu_location->name }}</td>
                            <td>{{ $menu_location->slug }}</td>
                            <td>
                                <div>
                                    <a class="button button-success button-action" href="{{ route('menu_locations.edit', $menu_location) }}">
                                        @icon('edit')
                                    </a>
                                    <form action="{{ route('menu_locations.destroy', $menu_location) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button-error button-action"  onclick="return confirm('Er du sikker på at du vil slette meny plasseringen?')">@icon('trash')</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @include('partials.nav-pagination', ['pagination_items' => $menu_locations])
        </div>
    </div>
@endsection
