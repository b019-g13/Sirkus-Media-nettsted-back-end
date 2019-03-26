@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Rediger Linken </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('links.index') }}"> Tilbake </a>
            </div>
        </div>
    </div>
  
    <form action="{{ route('links.update', $link->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    @csrf
                    <strong> Navn: </strong>
                    <input type="text" name="name" value="{{old('name', (isset($link->name)? $link->name : null))}}" required class="form-control" placeholder="Navn">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    @csrf
                    <strong> Verdi: </strong>
                    <input type="text" name="value" value="{{old('value', (isset($link->value)? $link->value : null))}}" required class="form-control" placeholder="Verdi">
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong> Page :</strong>
                    <select name="page_id" class="form-control" >
                        <option></option>
                        @foreach($pages as $page)
                            <option value="{{$page->id}}" {{('page_id' == $page->id)? 'selected' : '' }}> {{$page->title}} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary"> Oppdater </button>
            </div>
        </div>

    </form>
@endsection
