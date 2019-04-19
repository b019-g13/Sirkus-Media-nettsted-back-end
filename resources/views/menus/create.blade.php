@extends('layouts.app')
@section('content')
<h2>Legg til ny Menu</h2>
<a href="{{ route('menus.index') }}" class="button">
    @icon('arrow-left')
    <span>Tilbake</span>
</a>
   
<form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            @csrf
                <strong> Navn: </strong>
                <input type="text" name="name" value="{{old('name', (isset($menu->name)? $menu->name : null))}}" required class="form-control" placeholder="Navn">
            </div>
        </div>
        
    <button type="submit" class="button-success">
        <span>Opprett</span>
        @icon('save')
    </button>
                        <option></option>  
                    @foreach($pages as $page)
                        <option value="{{$page->id}}" {{old('page_id', $page->id)}}? selected> {{$page->title}} </option>
                    @endforeach
                </select>       
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Velg lokasjon:</strong> 
                <select name="menu_location_id"  class="form-control" >
                        <option></option>
                        @foreach($locations as $location)
                            <option value="{{$location->id}}" {{old('menu_location_id', $location->id)}}? selected> {{$location->name}} </option>
                        @endforeach
                </select>         
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Global :</strong>
                <input type="text" name="global" value="{{old('global', (isset($menu->global)? $menu->global : null))}}" required class="form-control" placeholder="Global">
            </div>
        </div>

   
</form>
@endsection
