<div class="form-group">
    <label for="form-site_setting-name">Navn</label>
    <input id="form-site_setting-name" type="text" name="name" value="{{ old('name', (isset($site_setting->name) ? $site_setting->name : null)) }}" required>
</div>
<div class="form-group">
    <label for="form-site_setting-value">Verdi</label>
    <textarea id="form-site_setting-value" name="value">{!! old('value', (isset($site_setting->value) ? $site_setting->value : null)) !!}</textarea>
</div>
