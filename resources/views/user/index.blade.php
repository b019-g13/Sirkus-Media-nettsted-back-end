@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('user')
                    <span>Brukere</span>
                </h1>
                <p>Oversikt over alle brukere.</p>
            </div>
            <div class="actions">
                <a href="{{ route('register') }}" class="button button-primary-alt">
                    @icon('user-plus')
                    <span>Ny bruker</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            <table class="first-bold">
                <thead>
                    <tr>
                        <th>Navn</th>
                        <th>E-post</th>
                        <th>Mobil</th>
                        <th class="auto-hide">Opprettet</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div>
                                    <img class="avatar" src="{{ $user->image->url_full }}" alt="{{ $user->image->attribute_alt }}">
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td class="auto-hide" title="{{ $user->created_at->diffForHumans() }}">{{ $user->created_at->format('d-m-Y') }}</td>
                            <td>
                                <div>
                                    <button class="button-error button-action">@icon('trash')</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
