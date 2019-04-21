@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2> Menu </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('menus.create') }}"> Oprett ny menu </a>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>Navn</th>
            <th>Lokasjon</th>
            <th>Global</th>
            <th>Page </th>
            <th>Handling</th>
        </tr>
        @foreach ($menus as $menu)
        <tr>
            <td>{{ $menu->name }}</td>
            <td>{{ $menu->menu_location ? $menu->menu_location->name : null }}</td>
            <td>{{ $menu->global ? 'Ja' : 'Nei' }}</td>
            <td>{{ $menu->page ? $menu->page->title : null }}</td>
            <td>
                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" enctype="multipart/form-data">
                     @csrf

                    <a class="btn btn-info" href="{{ route('menus.show',$menu->id) }}"> Vis </a>

                    <a class="btn btn-primary" href="{{ route('menus.edit',$menu->id) }}"> Rediger </a>

                    @method('DELETE')

                    <button type="submit" class="btn btn-danger"  onclick="return confirm('Er du sikkert å slette det?')"> Slett </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $menus->onEachSide(1)->links() }}
@endsection
