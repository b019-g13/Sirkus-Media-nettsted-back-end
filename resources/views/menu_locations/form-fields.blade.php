<div class="form-group">
    <label for="name">Navn</label>
    <input id="name" type="text" name="name" value="{{ old('name', (isset($menu_location->name) ? $menu_location->name : null)) }}" required>
</div>