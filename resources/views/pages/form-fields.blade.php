    <div class="form-group">
        <input type="text" name="title" value="{{ old('title', (isset($page->title) ? $page->title : null)) }}" required>
    </div>

    <div class="form-group">
        <label for="image_id">Forelder</label>
        <select id="image_id" name="image_id">
            @php
                $old_value = old('image_id', isset($component->image_id) ? $component->image_id : null);
            @endphp
            @if ($old_value == null)
                <option value="" hidden selected disabled>Velg en</option>
            @endif
            <option value="">Ingen forelder</option>
            @foreach ($images as $image)
                @if ($old_value == $image->id)
                    <option value="{{ $image->id }}" selected>{{ $image->url }}</option>
                @else
                    <option value="{{ $image->id }}">{{ $image->url }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <section>
        <h3>Legg til komponenter for siden</h3>

        <div id="drag-area-wrapper">
            <p class="heading">Tilgjengelig komponenter</p>
            <ul class="drag-area drag-area-source">
                @foreach ($components as $component)
                    <li class="draggable" data-component_id="{{ $component->id }}">
                        {!! $component->getFieldsAndChildrenHTML() !!}
                    </li>
                @endforeach
            </ul>

            <p class="heading">Sidens komponenter</p>
            <ul class="drag-area drag-area-destination">
                @if (isset($page->components))
                    @foreach ($page->components as $component)
                        <li class="draggable" data-component_id="{{ $component->id }}">
                            {!! $component->getFieldsAndChildrenHTML() !!}
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <input id="drag-area-input" name="components" type="hidden">
    </section>
