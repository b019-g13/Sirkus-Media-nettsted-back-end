@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('user')
                    <span>{{ __('Users') }}</span>
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
            @if (!$users->onFirstPage())
                <p>{{ __('Page') }} {{ $users->currentPage() }}</p>
            @endif
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
                                    @if ((!$user->hasRole('superadmin') || $current_user->hasRole('superadmin')))
                                        <form action="{{ route('user.destroy', $user) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button-error button-action"  onclick="return confirm('Er du sikker på at du vil slette brukeren?')">@icon('trash')</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @include('partials.nav-pagination', ['pagination_items' => $users])
        </div>
    </div>
@endsection
