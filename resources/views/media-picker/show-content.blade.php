<form id="media-picker-form"
    action="{{ route('media-picker.store') }}"
    method="POST"
    enctype="multipart/form-data"
    data-action_delete="{{ route('media-picker.destroy', 'MEDIUM_ID') }}"
    data-action_refresh="{{ route('media-picker.show_refresh') }}"
>
    @csrf
    <section id="media-picker">
        <header class="media-picker-header">
            <button type="button" class="media-picker-button-close">
                <span>Lukk</span>
                @icon('x')
            </button>
            <h1>Media velger</h1>
            <p>Her kan du laste opp eller velge eksisterende media</p>
        </header>
        <div class="media-picker-body">
            <input id="media-picker-medium-preview-radio" class="media-picker-medium-input" type="radio" name="selected_medium" value="preview" data-preview="" required>
            <label id="media-picker-upload-preview" class="media-picker-medium" for="media-picker-medium-preview-radio">
                <img src="#" alt="no img">
            </label>

            @include('media-picker.show-content-row')
        </div>
        <footer class="media-picker-footer">
            <nav class="media-picker-footer-nav">
                <button type="button" class="button-blank button-error media-picker-button-delete">
                    <span>Slett</span>
                    @icon('trash')
                </button>
                <input type="file" name="upload_medium" id="media-picker-upload-input" class="hide">
                <button type="button" id="media-picker-upload-trigger" class="button-dark">
                    <span>Last opp nytt</span>
                    @icon('load', 'spinner')
                    @icon('upload-cloud')
                </button>
                <button type="submit" id="media-picker-submit" class="button-primary">
                    <span>Velg</span>
                    @icon('load', 'spinner')
                    @icon('save')
                </button>
            </nav>
        </footer>
    </section>
</form>
