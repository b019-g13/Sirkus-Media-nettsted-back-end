@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Rediger field </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('fields.index') }}"> Tilbake </a>
            </div>
        </div>
    </div>

    <form action="{{ route('fields.update', $field->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    @csrf
                    <strong> Navn : </strong>
                    <input type="text" name="name" value="{{old('name', (isset($field->name)? $field->name : null))}}" required class="form-control" placeholder="Navn">
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary"> Oppdater </button>
            </div>
        </div>

    </form>
@endsection
