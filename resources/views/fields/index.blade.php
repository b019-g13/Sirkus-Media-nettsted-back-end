@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('tag')
                    <span>Felter</span>
                </h1>
                <p>Oversikt over alle felter.</p>
            </div>
            <div class="actions">
                <a href="{{ route('fields.create') }}" class="button button-primary-alt">
                    @icon('plus-square')
                    <span>Nytt felt</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            @if (!$fields->onFirstPage())
                <p>{{ __('Page') }} {{ $fields->currentPage() }}</p>
            @endif
            <table class="first-bold">
                <thead>
                    <tr>
                        <th>Navn</th>
                        <th class="auto-hide">Slug</th>
                        <th>Type</th>
                        <th class="auto-hide">Sist redigert</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fields as $field)
                        <tr>
                            <td>{{ $field->name }}</td>
                            <td class="auto-hide">{{ $field->slug }}</td>
                            <td>{{ $field->field_type->name }}</td>
                            <td class="auto-hide" title="{{ $field->created_at->diffForHumans() }}">{{ $field->created_at->format('d-m-Y') }}</td>
                            <td>
                                <div>
                                    <a class="button button-success button-action" href="{{ route('fields.edit', $field) }}">
                                        @icon('edit')
                                    </a>
                                    <form action="{{ route('fields.destroy', $field) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button-error button-action"  onclick="return confirm('Er du sikker på at du vil slette feltet?')">@icon('trash')</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @include('partials.nav-pagination', ['pagination_items' => $fields])
        </div>
    </div>
@endsection
