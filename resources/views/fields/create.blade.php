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
   
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Ops!</strong> Sjekk om fletene er oppfylt  <br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
<form action="{{ route('fields.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            @csrf
                <strong> Navn : </strong>
                <input type="text" name="name" class="form-control" placeholder="Navn">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                @csrf
                <strong> Slug : </strong>
                <input type="text" name="slug" class="form-control" placeholder="Slug">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary"> Opprett </button>
        </div>
    </div>
   
</form>
@endsection
