<div class="component-field component-field-type-{{ $field->type }} form-group" data-component_field_id="{{ $field->component_field_id }}" data-field_type="{{ $field->type }}">
    <label>{{ $field->nickname }}</label>

    @if ($field->type == 'string' || $field->type == 'icon')
        <input class="cf-input" type="text" value="{{ $field->value }}">
    @elseif ($field->type == 'url_internal' || $field->type == 'url_external')
        <input class="cf-input" type="hidden" value="{{ $field->value ? $field->value->id : null }}">
        <button type="button" class="modal-trigger" data-modal="menu-modal-pick-link">
            @icon('link')
            <span>Velg link</span>
        </button>
        <div></div>
        <p class="cf-link-picker-selected"></p>
    @elseif ($field->type == 'hex_color')
        <input class="cf-input" type="color" value="{{ $field->value }}">
    @elseif ($field->type == 'text')
        <textarea class="cf-input">{{ $field->value }}</textarea>
    @elseif ($field->type == 'image')
    @php
        $id = null;
        $url = null;

        if (!empty($field->value)) {
            $id = $field->value->id;
            $url = asset('storage/' . $field->value->url);
        }
    @endphp
        <div class="cf-media-picker" data-value="{{ $url }}">
            <button class="mp-trigger-open" type="button">
                @icon('image')
                <span>Velg bilde</span>
            </button>
            <button class="mp-trigger-delete" type="button">
                @icon('x')
                <span>Fjern bilde</span>
            </button>
            <input class="cf-input" value="{{ $id }}" type="text">
        </div>
    @else
        <input class="cf-input" type="text" value="{{ $field->value }}">
    @endif
</div>
