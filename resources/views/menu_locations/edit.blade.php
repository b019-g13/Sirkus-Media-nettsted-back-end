@extends('layouts.app')
@section('content')
<h2>Rediger lokasjon</h2>
<a href="{{ route('menu_locations.index') }}" class="button">
    @icon('arrow-left')
    <span>Tilbake</span>
</a>


    <form action="{{ route('menu_locations.update', $menu_location->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    @csrf
                    <strong> Navn : </strong>
                    <input type="text" name="name" value="{{old('name', (isset($menu_location->name)? $menu_location->name : null))}}" required class="form-control" placeholder="Navn">
                </div>
            </div>

            <button type="submit" class="button-success">
                <span>Oppdater</span>
                @icon('save')
            </button>
        </div>

    </form>
@endsection
