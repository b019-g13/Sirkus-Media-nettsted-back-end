<div class="form-group">
    <input type="text" name="name" value="{{ old('name', (isset($field->name) ? $field->name : null)) }}" required>
</div>
<div class="form-group">
    <label for="field_type_id">Felt type</label>
    <select id="field_type_id" name="field_type_id" required>
        @php
            $old_value = old('field_type_id', isset($field->field_type_id) ? $field->field_type_id : null);
        @endphp
        @if ($old_value == null)
            <option value="" hidden selected disabled>Velg en</option>
        @endif
        @foreach ($field_types as $field_type)
            @if ($old_value == $field_type->id)
                <option value="{{ $field_type->id }}" selected>{{ $field_type->name }}</option>
            @else
                <option value="{{ $field_type->id }}">{{ $field_type->name }}</option>
            @endif
        @endforeach
    </select>
</div>
