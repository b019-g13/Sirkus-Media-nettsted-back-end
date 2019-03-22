@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Locasjon </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('menu_locations.index') }}"> Tilbake </a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Menu-lokasjon ID :</strong>
                {{ $menu_location->id }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Navn :</strong>
                {{ $menu_location->name }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Slug : </strong>
                {{ $menu_location->slug }}
            </div>
        </div>
        
    </div>
@endsection