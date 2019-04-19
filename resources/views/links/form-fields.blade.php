<div class="form-group">
    <label for="form-link-name">Navn</label>
    <input id="form-link-name" type="text" name="name" value="{{ old('name', (isset($link->name) ? $link->name : null)) }}" required>
</div>

<div class="form-group form-group-switch form-group-switch-yn">
    <input id="form-link-internal" type="checkbox" checked>
    <label for="form-link-internal">Intern link?</label>
</div>

<div class="form-group form-group-conditional" data-condition-switch="form-link-internal">
    <label for="form-link-value">Ekstern link</label>
    <input id="form-link-value" type="text" name="value" value="{{ old('value', (isset($link->value) ? $link->value : null)) }}">
</div>

<div class="form-group form-group-conditional form-group-conditional-reverse" data-condition-switch="form-link-internal">
    <strong> Velg page:</strong>
    <select name="page_id"  class="form-control" >
        <option></option>
        @foreach($pages as $page)
            <option value="{{$page->id}}" {{('page_id' == $page->id)? 'selected' :'' }}> {{$page->title}} </option>
        @endforeach
    </select>
</div>
