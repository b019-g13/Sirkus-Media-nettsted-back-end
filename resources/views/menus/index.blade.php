@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('list')
                    <span>Menyer</span>
                </h1>
                <p>Oversikt over alle menyer.</p>
            </div>
            <div class="actions">
                <a href="{{ route('menus.create') }}" class="button button-primary-alt">
                    @icon('plus-square')
                    <span>Ny meny</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            <table class="first-bold">
                <thead>
                    <tr>
                        <th>Navn</th>
                        <th>Lokasjon</th>
                        <th>Global</th>
                        <th>Side</th>
                        <th>Handling</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                        <tr>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->menu_location ? $menu->menu_location->name : null }}</td>
                            <td>{{ $menu->global ? 'Ja' : 'Nei' }}</td>
                            <td>{{ $menu->page ? $menu->page->title : null }}</td>
                            <td>
                                <div>
                                    <a class="button button-success button-action" href="{{ route('menus.edit', $menu) }}">
                                        @icon('edit')
                                    </a>
                                    <form action="{{ route('menus.destroy', $menu) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button-error button-action"  onclick="return confirm('Er du sikker på at du vil slette menyen?')">@icon('trash')</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $menus->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
