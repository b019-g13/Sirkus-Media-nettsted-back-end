@extends('layouts.app')
@section('content')
    <h2>Legg til ny Page</h2>
    <a href="{{ route('pages.index') }}">← Tilbake</a>

    <form id="form-page" action="{{ route('pages.store') }}" method="POST">
        @csrf

        @include('pages.form-fields')

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
             @csrf
                <strong>Tittel:</strong>
                <input type="text" name="title" value="{{old('title', (isset($page->title)? $page->title : null))}}" required class="form-control" placeholder="Tittel">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Bilde ID:</strong>
                <select name="image_id"  class="form-control" >
                    <option></option>
                    @foreach($images as $image)
                    <option value="{{$image->id}}" {{old('image_id', $image->id)}}? selected> {{$image->url}} </option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary"> Opprett </button>
        </div>
    </div>
   
</form>
        <button type="submit">Opprett</button>
    </form>

    <script src="{{ asset('js/page.js') }}"></script>
@endsection
