<form action="">
    <section id="media-picker">
        <header class="media-picker-header">
            <h1>Media velger</h1>
            <p>Her kan du laste opp eller velge eksisterende media</p>
        </header>
        <div class="media-picker-body">
            @foreach ($media as $medium)
                <input id="media-picker-medium-{{ $medium->id }}" class="media-picker-medium-input" type="radio" name="selected-medium" value="{{ $medium->id }}" required>
                <label class="media-picker-medium" for="media-picker-medium-{{ $medium->id }}">
                    <img src="{{ $medium->url }}" alt="{{ $medium->alt }}">
                </label>
            @endforeach
        </div>
        <footer class="media-picker-footer">
            <nav class="media-picker-footer-nav">
                <button type="button">Lukk</button>
                <input type="file" id="media-picker-upload-input" class="hide">
                <button type="button" id="media-picker-upload-trigger">Last opp nytt</button>
                <button type="submit">Velg</button>
            </nav>
        </footer>
    </section>
</form>
