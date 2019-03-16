@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2> Page </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('pages.create') }}">Opprett ny Page</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th> Page ID</th>
            <th> Tittel </th>
            <th> Bilde </th>
            <th width="280px"> Handling </th>
        </tr>
        @foreach ($pages as $page)
        <tr>
            <td>{{ $page->id }}</td>
            <td>{{ $page->title }}</td>
            <td>{{ $page->image_id }}</td>
            <td>
                <form action="{{ route('pages.destroy',$page->id) }}" method="POST" enctype="multipart/form-data">
                     @csrf

                    <a class="btn btn-info" href="{{ route('pages.show',$page->id) }}"> Vis </a>
    
                    <a class="btn btn-primary" href="{{ route('pages.edit',$page->id) }}"> Rediger </a>
   
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger"  onclick="return confirm('Er du sikkert å slette det?')"> Slett </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $pages->onEachSide(1)->links() }}
@endsection
