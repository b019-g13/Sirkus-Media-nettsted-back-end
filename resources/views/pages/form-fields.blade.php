    <div class="form-group">
        <label for="form-page-title">Tittel</label>
        <input id="form-page-title" type="text" name="title" value="{{ old('title', (isset($page->title) ? $page->title : null)) }}" required>
    </div>

    <section>
        <h3>Legg til komponenter for siden</h3>

        <div id="page-component-superparent"
            class="page-component"
            data-component_id="superparent"
            data-component_get_url="{{ route('components.show', 'COMPONENT_ID') }}"
        >
            <div class="page-component-contents">
                <div class="page-component-children">
                    @if (isset($page))
                        @foreach ($page->components as $component)
                            @include('components.show')
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="page-component-footer">
                <button type="button" class="modal-trigger page-component-add" data-modal="page-modal-pick-component">
                    @icon('package')
                    <span>Legg til komponent</span>
                </button>
            </div>
        </div>

        <input id="page-components-input" name="components" type="hidden">
    </section>
