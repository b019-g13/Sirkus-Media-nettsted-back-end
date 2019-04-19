@extends('layouts.app')
@section('content')
    <h2>Legg til ny Link</h2>

    <a href="{{ route('links.index') }}" class="button">
        @icon('arrow-left')
        <span>Tilbake</span>
    </a>

<form action="{{ route('links.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            @csrf
                <strong> Navn: </strong>
                <input type="text" name="name" value="{{old('name', (isset($link->name)? $link->name : null))}}" required class="form-control" placeholder="Navn">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                @csrf
                <strong> Verdi: </strong>
                <input type="text" name="value" value="{{old('value', (isset($link->value)? $link->value : null))}}" required class="form-control" placeholder="Verdi">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong> Velg page:</strong>
                <select name="page_id"  class="form-control" >
                    <option></option>
                    @foreach($pages as $page)
                        <option value="{{$page->id}}" {{('page_id' == $page->id)? 'selected' :'' }}> {{$page->title}} </option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="button-success">
            <span>Opprett</span>
            @icon('save')
        </button>
    </div>

</form>
@endsection
