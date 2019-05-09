@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('file-text')
                    <span>Sider</span>
                </h1>
                <p>Oversikt over alle sider.</p>
            </div>
            <div class="actions">
                <a href="{{ route('pages.create') }}" class="button button-primary-alt">
                    @icon('file-plus')
                    <span>Ny side</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            @if (!$pages->onFirstPage())
                <p>Side {{ $pages->currentPage() }}</p>
            @endif
            <table class="first-bold">
                <thead>
                    <tr>
                        <th>Navn</th>
                        <th>Slug</th>
                        <th class="auto-hide">Sist redigert</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $page)
                        <tr>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->slug }}</td>
                            <td class="auto-hide" title="{{ $page->created_at->diffForHumans() }}">{{ $page->created_at->format('d-m-Y') }}</td>
                            <td>
                                <div>
                                    <a class="button button-success button-action" href="{{ route('pages.edit', $page) }}">
                                        @icon('edit')
                                    </a>
                                    <form action="{{ route('pages.destroy', $page) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button-error button-action"  onclick="return confirm('Er du sikker på at du vil slette siden?')">@icon('trash')</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @include('partials.nav-pagination', ['pagination_items' => $pages])
        </div>
    </div>
@endsection
