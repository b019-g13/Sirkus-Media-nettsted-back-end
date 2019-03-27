<div class="form-group">
        <label>Navn</label>
        <input type="text" name="name" value="{{ old('name', (isset($component->name) ? $component->name : null)) }}" required>
    </div>

    <div class="form-group">
        <label for="parent_id">Forelder</label>
        <select id="parent_id" name="parent_id" required>
            @php
                $old_value = old('parent_id', isset($component->parent_id) ? $component->parent_id : null);
            @endphp
            @if ($old_value == null)
                <option value="" hidden selected disabled>{{ __('Velg en') }}</option>
            @endif
            @foreach ($components as $parent_component)
                @if ($old_value == $parent_component->id)
                    <option value="{{ $parent_component->id }}" selected>{{ $parent_component->name }}</option>
                @else
                    <option value="{{ $parent_component->id }}">{{ $parent_component->name }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <section>
        <h3>Legg til felter for komponenten</h3>

        <div id="component-fields-drag">
            <p class="heading">Tilgjengelig felter</p>
            <ul class="component-fields component-fields-source">
                @foreach ($fields as $field)
                    <li class="draggable component-field" data-field_id="{{ $field->id }}">
                        <span>{{ $field->name }}</span>
                    </li>
                @endforeach
            </ul>

            <p class="heading">Komponentens felter</p>
            <ul class="component-fields component-fields-destination">
                @if (isset($component->fields))
                    @foreach ($component->fields as $field)
                        <li class="draggable component-field" data-field_id="{{ $field->id }}">
                            <span>{{ $field->name }}</span>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <input id="component-fields-input" name="fields" type="hidden">
    </section>
