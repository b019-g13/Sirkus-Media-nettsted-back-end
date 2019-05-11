@php
    $unique_component_id = 'component-' . md5(uniqid(rand(), true));
@endphp
<input id="{{ $unique_component_id }}" type="radio" name="component" value="{{ $component->id }}" required>
<label for="{{ $unique_component_id }}">{{ $component->name }}</label>