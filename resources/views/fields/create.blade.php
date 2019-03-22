@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> Legg til ny field </h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('fields.index') }}"> Tilbake </a>
        </div>
    </div>
</div>
   
<form action="{{ route('fields.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            @csrf
                <strong> Navn : </strong>
                <input type="text" name="name"  value="{{old('name', (isset($field->name)? $field->name : null))}}" required class="form-control" placeholder="Navn">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary"> Opprett </button>
        </div>
    </div>
   
</form>
@endsection
