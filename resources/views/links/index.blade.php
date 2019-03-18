@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2> Link </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('links.create') }}"> Oprett ny komponent </a>
            </div>
        </div>
    </div>
   
    @include('messages.flash-message')
   
    <table class="table table-bordered">
        <tr>
            <th> Link ID</th>
            <th> Navn </th>
            <th> Verdi  </th>
            <th> Page </th>
            <th width="280px"> Handling </th>
        </tr>
        @foreach ($links as $link)
        <tr>
            <td>{{ $link->id }}</td>
            <td>{{ $link->name }}</td>
            <td>{{ $link->value }}</td>
            <td>{{ $link->page_id }}</td>
            <td>
                <form action="{{ route('links.destroy' , $link->id) }}" method="POST" enctype="multipart/form-data">
                     @csrf

                    <a class="btn btn-info" href="{{ route('links.show',$link->id) }}"> Vis </a>
    
                    <a class="btn btn-primary" href="{{ route('links.edit',$link->id) }}"> Rediger </a>
   
                    @method('DELETE')
   
                    <button type="submit" class="btn btn-danger"  onclick="return confirm('Er du sikkert å slette det?')"> Slett </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $links->onEachSide(1)->links() }}
@endsection
