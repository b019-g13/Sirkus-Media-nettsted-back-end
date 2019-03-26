@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Rediger Page</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('pages.index') }}"> Tilbake </a>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops!</strong> Sjekk om fletene er oppfylt <br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('pages.update', $page->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Tittel :</strong>
                    <input type="text" name="title" value="{{ $page->title }}" class="form-control" placeholder="Tittel">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Bilde :</strong>
                    <select name="image_id"  class="form-control" >
                        <option></option>
                        @foreach($images as $image)
                            <option value="{{$image->id}}" {{old('image_id', $image->id)}}? selected> {{$image->url}} </option>
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
