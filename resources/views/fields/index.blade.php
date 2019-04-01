@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2>Field</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('fields.create') }}"> Oprett ny field </a>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>Navn</th>
            <th>Slug</th>
            <th>Type</th>
            <th>Handling</th>
        </tr>
        @foreach ($fields as $field)
        <tr>
            <td>{{ $field->name }}</td>
            <td>{{ $field->slug }}</td>
            <td>{{ $field->field_type->name }}</td>
            <td>
                <form action="{{ route('fields.destroy' , $field->id) }}" method="POST" enctype="multipart/form-data">
                     @csrf

                    <a class="btn btn-info" href="{{ route('fields.show',$field->id) }}"> Vis </a>

                    <a class="btn btn-primary" href="{{ route('fields.edit',$field->id) }}"> Rediger </a>

                    @method('DELETE')

                    <button type="submit" class="btn btn-danger"  onclick="return confirm('Er du sikkert å slette det?')"> Slett </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $fields->onEachSide(1)->links() }}
@endsection
