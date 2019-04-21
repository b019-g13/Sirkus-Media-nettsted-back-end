@php
    // Random enough for our needs.
    // We just want to avoid collision in case the fields
    // are included multiple times on a single page
    $prefix = 'form-link-' . bin2hex(random_bytes(4));
@endphp

<div class="form-group">
    <label for="{{ $prefix }}-name">Navn</label>
    <input id="{{ $prefix }}-name" type="text" name="name" value="{{ old('name', (isset($link->name) ? $link->name : null)) }}" required>
</div>

<div class="form-group form-group-switch form-group-switch-yn">
    <input id="{{ $prefix }}-internal" name="internal" type="checkbox" checked>
    <label for="{{ $prefix }}-internal">Intern link?</label>
</div>

<div class="form-group form-group-conditional form-group-conditional-reverse" data-condition-switch="{{ $prefix }}-internal">
    <label for="{{ $prefix }}-value">Link</label>
    <input id="{{ $prefix }}-value" type="text" name="value" value="{{ old('value', (isset($link->value) ? $link->value : null)) }}">
</div>

<div class="form-group form-group-conditional" data-condition-switch="{{ $prefix }}-internal">
    <label for="{{ $prefix }}-page_id">Side</label>
    <select id="{{ $prefix }}-page_id" name="page_id">
        @php
            $old_value = old('page_id', isset($link->page_id) ? $link->page_id : null);
        @endphp
        @if ($old_value == null)
            <option value="" hidden selected disabled>Velg en</option>
        @endif
        @foreach ($pages as $page)
            @if ($old_value == $page->id)
                <option value="{{ $page->id }}" selected>{{ $page->title }}</option>
            @else
                <option value="{{ $page->id }}">{{ $page->title }}</option>
            @endif
        @endforeach
    </select>
</div>
