@extends('partials.master')

@section('content')
    <header>
        <div class="header-inner">
            <div class="info">
                <h1>
                    @icon('settings')
                    <span>{{ __('Settings') }}</span>
                </h1>
                <p>{{ __('Overview of all settings.') }}</p>
            </div>
            <div class="actions">
                <a href="{{ route('site_settings.create') }}" class="button button-primary-alt">
                    @icon('file-plus')
                    <span>{{ __('New setting') }}</span>
                </a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-inner">
            @if (!$site_settings->onFirstPage())
                <p>{{ __('Page') }} {{ $site_settings->currentPage() }}</p>
            @endif
            <table class="first-bold">
                <thead>
                    <tr>
                        <th>Navn</th>
                        <th>Verdi</th>
                        <th class="auto-hide">Sist redigert</th>
                        <th class="auto-hide">Opprettet</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($site_settings as $site_setting)
                        <tr>
                            <td>{{ $site_setting->name }}</td>
                            <td class="truncate">{{ substr($site_setting->value, 0, 150) }}</td>
                            <td class="auto-hide" title="{{ $site_setting->updated_at->diffForHumans() }}">{{ $site_setting->updated_at->format('d-m-Y') }}</td>
                            <td class="auto-hide" title="{{ $site_setting->created_at->diffForHumans() }}">{{ $site_setting->created_at->format('d-m-Y') }}</td>
                            <td>
                                <div>
                                    <a class="button button-success button-action" href="{{ route('site_settings.edit', $site_setting) }}">
                                        @icon('edit')
                                    </a>
                                    <form action="{{ route('site_settings.destroy', $site_setting) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button-error button-action"  onclick="return confirm('Er du sikker på at du vil slette innstillingen?')">@icon('trash')</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @include('partials.nav-pagination', ['pagination_items' => $site_settings])
        </div>
    </div>
@endsection
