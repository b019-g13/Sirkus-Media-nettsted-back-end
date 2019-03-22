@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2> Lokasjon </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('menu_locations.create') }}"> Oprett ny lokasjon </a>
            </div>
        </div>
    </div>
   
    <table class="table table-bordered">
        <tr>
            <th> Lokasjon ID</th>
            <th> Navn </th>
            <th> Slug  </th>
            <th width="280px"> Handling </th>
        </tr>
        @foreach ($menu_locations as $location)
        <tr>
            <td>{{ $location->id }}</td>
            <td>{{ $location->name }}</td>
            <td>{{ $location->slug }}</td>
            <td>
                <form action="{{ route('menu_locations.destroy' , $location->id) }}" method="POST" enctype="multipart/form-data">
                     @csrf

                    <a class="btn btn-info" href="{{ route('menu_locations.show',$location->id) }}"> Vis </a>
    
                    <a class="btn btn-primary" href="{{ route('menu_locations.edit',$location->id) }}"> Rediger </a>
   
                    @method('DELETE')
   
                    <button type="submit" class="btn btn-danger"  onclick="return confirm('Er du sikker?')"> Slett </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $menu_locations->onEachSide(1)->links() }}
@endsection
