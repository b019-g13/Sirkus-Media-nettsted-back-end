<form action="{{ route('media-picker.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section id="media-picker">
        <header class="media-picker-header">
            <h1>Media velger</h1>
            <p>Her kan du laste opp eller velge eksisterende media</p>
        </header>
        <div class="media-picker-body">
            <input id="media-picker-medium-preview-radio" class="media-picker-medium-input" type="radio" name="selected-medium" value="preview" data-preview="" required>
            <label id="media-picker-upload-preview" class="media-picker-medium" for="media-picker-medium-preview-radio">
                <img src="#" alt="no img">
            </label>

            @foreach ($media as $medium)
                <input id="media-picker-medium-{{ $medium->id }}" class="media-picker-medium-input" type="radio" name="selected-medium" value="{{ $medium->id }}" data-preview={{ asset('storage/' . $medium->url) }} required>
                <label class="media-picker-medium" for="media-picker-medium-{{ $medium->id }}">
                    <img src="{{ asset('images/placeholder.svg') }}" data-url={{ asset('storage/' . $medium->url) }} alt="{{ $medium->alt }}">
                </label>
            @endforeach
        </div>
        <footer class="media-picker-footer">
            <nav class="media-picker-footer-nav">
                <button type="button" class="media-picker-button-close">
                    <span>Lukk</span>
                    @icon('x')
                </button>
                <input type="file" name="upload_medium" id="media-picker-upload-input" class="hide">
                <button type="button" id="media-picker-upload-trigger">
                    <span>Last opp nytt</span>
                    @icon('load', 'spinner')
                    @icon('upload-cloud')
                </button>
                <button type="submit" id="media-picker-submit">
                    <span>Velg</span>
                    @icon('load', 'spinner')
                    @icon('save')
                </button>
            </nav>
        </footer>
    </section>
</form>
