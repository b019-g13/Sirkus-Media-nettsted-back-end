@foreach ($media as $medium)
    <input id="media-picker-medium-{{ $medium->id }}" class="media-picker-medium-input" type="radio" name="selected-medium" value="{{ $medium->id }}" data-preview={{ asset('storage/' . $medium->url) }} required>
    <label class="media-picker-medium" for="media-picker-medium-{{ $medium->id }}">
        <img src="{{ asset('images/placeholder.svg') }}" data-url={{ asset('storage/' . $medium->url) }} alt="{{ $medium->alt }}">
    </label>
@endforeach