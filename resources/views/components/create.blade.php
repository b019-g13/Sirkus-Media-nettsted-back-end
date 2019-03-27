@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> Legg til ny komponent </h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('components.index') }}"> Tilbake </a>
        </div>
    </div>
</div>

<form id="form-components" action="{{ route('components.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            @csrf
                <strong> Navn : </strong>
                <input type="text" name="name" value="{{old('name', (isset($component->name)? $component->name : null))}}" required class="form-control" placeholder="Navn">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Velg komponent forelder :</strong>
                <select name="parent_id"  class="form-control" >
                        <option></option>
                    @foreach($components as $component)
                        <option value="{{$component->id}}" {{old('parent_id', $component->id)}}? selected > {{$component->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary"> Opprett </button>
        </div>
    </div>

    <input id="component-fields-input" name="fields" type="hidden">

    <section id="component-fields-drag">
        <h2 class="heading">Available fields</h2>
        <ul class="component-fields component-fields-source">
            @foreach ($fields as $field)
                <li class="draggable component-field" data-field_id="{{ $field->id }}">
                    <span>{{ $field->name }}</span>
                </li>
            @endforeach
        </ul>

        <h2 class="heading">Component fields</h2>
        <ul class="component-fields component-fields-destination"></ul>
    </section>
</form>
<script src="{{ asset('js/component.js') }}"></script>
@endsection
