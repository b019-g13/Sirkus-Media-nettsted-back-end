    <div class="form-group">
        <label for="form-page-title">Tittel</label>
        <input id="form-page-title" type="text" name="title" value="{{ old('title', (isset($page->title) ? $page->title : null)) }}" required>
    </div>

    <section>
        <h3>Legg til komponenter for siden</h3>

        <div id="drag-area-wrapper">
            <p class="heading">Tilgjengelig komponenter</p>
            <ul class="drag-area drag-area-source">
                @foreach ($components as $component)
                    <li class="draggable">
                        {!! $component->getFieldsAndChildrenHTML() !!}
                    </li>
                @endforeach
            </ul>

            <p class="heading">Sidens komponenter</p>
            <ul class="drag-area drag-area-destination">
                @if (isset($page->components))
                    @foreach ($page->components as $page_component)
                        <li class="draggable" >
                            {!! $page_component->getFieldsAndChildrenHTML() !!}
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <input id="drag-area-input" name="components" type="hidden">
    </section>
