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
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops!</strong> Sjekk om feltene er fylt <br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('links.update', $link->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    @csrf
                    <strong> Navn: </strong>
                    <input type="text" name="name" value="{{ $link->name }}" class="form-control" placeholder="Navn">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    @csrf
                    <strong> Verdi: </strong>
                    <input type="text" name="value" value="{{ $link->value }}" class="form-control" placeholder="Verdi">
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
