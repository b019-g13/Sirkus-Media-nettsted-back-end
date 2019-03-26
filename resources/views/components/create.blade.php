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
   
<form action="{{ route('components.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            @csrf
                <strong> Navn : </strong>
                <input type="text" name="name" value="{{old('name', (isset($component->name)? $component->name : null))}}" required class="form-control" placeholder="Navn">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            @csrf
                <strong> Order : </strong>
                <input type="number" name="order"  value="{{old('order', (isset($component->order)? $component->order : null))}}" required class="form-control" placeholder="Order">
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
   
</form>
@endsection
