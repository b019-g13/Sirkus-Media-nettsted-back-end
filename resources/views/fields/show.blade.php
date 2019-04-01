@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Field </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('fields.index') }}"> Tilbake </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Field ID :</strong>
                {{ $field->id }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Navn :</strong>
                {{ $field->name }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Slug : </strong>
                {{ $field->slug }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Type : </strong>
                {{ $field->field_type->name }}
            </div>
        </div>

    </div>
@endsection
