<div class="form-group">
    <label for="form-link-name">Navn</label>
    <input id="form-link-name" type="text" name="name" value="{{ old('name', (isset($link->name) ? $link->name : null)) }}" required>
</div>

<div class="form-group form-group-switch form-group-switch-yn">
    <input id="form-link-internal" type="checkbox" checked>
    <label for="form-link-internal">Intern link?</label>
</div>

<div class="form-group form-group-conditional form-group-conditional-reverse" data-condition-switch="form-link-internal">
    <label for="form-link-value">Link</label>
    <input id="form-link-value" type="text" name="value" value="{{ old('value', (isset($link->value) ? $link->value : null)) }}">
</div>

<div class="form-group form-group-conditional" data-condition-switch="form-link-internal">
    <label for="form-link-page_id">Side</label>
    <select id="form-link-page_id" name="form-link-page_id">
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
