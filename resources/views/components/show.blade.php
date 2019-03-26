@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Komponent </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('components.index') }}"> Tilbake </a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Komponent ID :</strong>
                {{ $component->id }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Navn :</strong>
                {{ $component->name }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Slug : </strong>
                {{ $component->slug }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Order :</strong>
                {{ $component->order}}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Forelder komponent : </strong>
                {{ $component->parent_id}}
            </div>
        </div>  
        
    </div>
@endsection