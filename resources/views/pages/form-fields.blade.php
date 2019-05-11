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


{{-- <article class="page-component" data-component_id="{{ $component->id }}">
    <header class="page-component-titlebar">
        <div class="actions-left">
            <button class="page-component-minimize" type="button">@icon('minus')</button>
            <button class="page-component-maximize" type="button">@icon('maximize')</button>
            <button class="page-component-remove" type="button">@icon('x')</button>
        </div>
        <h3 class="title">{{ $component->name}}</h3>
        <div class="acitons-right">
            <button class="page-component-move-up" type="button">@icon('chevron-up')</button>
            <button class="page-component-move-down" type="button">@icon('chevron-down')</button>
        </div>
    </header>
    <section class="page-component-contents">
        <section class="page-component-fields">
            @foreach ($component->fields as $field)
                @include('components.field_types')
            @endforeach
        </section>
        <section class="page-component-children"></section>
    </section>
    <footer>
        <button type="button" class="modal-trigger" data-modal="page-modal-pick-component" title="Velg komponent for {{ $component->name}}">
            @icon('package')
            <span>Velg komponent</span>
        </button>
    </footer>
</article> --}}

        {{-- <div id="drag-area-wrapper"> --}}
            {{-- <p class="heading">Tilgjengelig komponenter</p> --}}
            {{-- <ul class="drag-area drag-area-source"> --}}
                {{-- @foreach ($components as $component) --}}
                {{-- {!! $component->getFieldsAndChildrenHTML() !!} --}}
                    {{-- <li class="draggable"> --}}
                    {{-- </li> --}}
                {{-- @endforeach --}}
            {{-- </ul> --}}

            {{-- <p class="heading">Sidens komponenter</p>
            <ul class="drag-area drag-area-destination">
                @if (isset($page->components))
                    @foreach ($page->components as $page_component)
                        <li class="draggable" >
                            {!! $page_component->getFieldsAndChildrenHTML() !!}
                        </li>
                    @endforeach
                @endif
            </ul> --}}
        {{-- </div> --}}

        {{-- <input id="drag-area-input" name="components" type="hidden"> --}}
    </section>
