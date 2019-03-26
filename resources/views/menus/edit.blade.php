@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Rediger Menu </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('menus.index') }}"> Tilbake </a>
            </div>
        </div>
    </div>
  
    <form action="{{ route('menus.update', $menu->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong> Navn: </strong>
                    <input type="text" name="name" value="{{old('name', (isset($menu->name)? $menu->name : null))}}" required class="form-control" placeholder="Navn">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong> Velg page :</strong>
                    <select name="page_id" class="form-control" >
                            <option></option>
                        @foreach($pages as $page)
                            <option value="{{$page->id}}" {{old('page_id', $page->id)}}? selected> {{$page->title}} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong> Velg lokasjon :</strong>
                    <select name="menu_location_id" class="form-control" >
                            <option></option>
                        @foreach($locations as $location)
                            <option value="{{$location->id}}" {{'menu_location_id', $location->id}}? selected> {{$location->name}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
             
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong> Global: </strong>
                    <input type="text" name="global" value="{{old('global', (isset($menu->global)? $menu->global : null))}}" required class="form-control" placeholder="Global">
                </div>
             </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary"> Oppdater </button>
            </div>
        </div>

    </form>
@endsection
