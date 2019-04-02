@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2> Komponenter </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('components.create') }}"> Oprett ny komponent </a>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>Navn</th>
            <th>Slug</th>
            <th>Forelder</th>
            <th>Handling</th>
        </tr>
        @foreach ($components as $component)
        <tr>
            <td>{{ $component->name }}</td>
            <td>{{ $component->slug }}</td>
            <td>{{ $component->parent ? $component->parent->name : null }}</td>
            <td>
                <form action="{{ route('components.destroy' , $component->id) }}" method="POST" enctype="multipart/form-data">
                     @csrf

                    <a class="btn btn-info" href="{{ route('components.show',$component->id) }}"> Vis </a>

                    <a class="btn btn-primary" href="{{ route('components.edit',$component->id) }}"> Rediger </a>

                    @method('DELETE')

                    <button type="submit" class="btn btn-danger"  onclick="return confirm('Er du sikkert å slette det?')"> Slett </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $components->onEachSide(1)->links() }}
@endsection
