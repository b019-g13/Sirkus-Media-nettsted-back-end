@php
    $component_classes = 'page-component';
    
    if ($component->slug !== null) {
        $component_classes .= ' page-component--' . $component->slug;
    } else {
        $component_classes .= ' page-component--' . str_slug($component->name);
    }
    
    if (!isset($parent_component_id)) {
        $component_classes .= ' page-component-parent';
    }

    $component_id = $component->component_id;
    if ($component_id === null) {
        $component_id = $component->id;
    }
@endphp
<article class="{{ $component_classes }}" data-component_id="{{ $component_id }}">
    <header class="page-component-titlebar">
        <div class="actions-left">
            <button class="button-action button-error page-component-remove" type="button">@icon('x')</button>
            <button class="button-action button-success page-component-maximize" type="button">@icon('maximize-2')</button>
            <button class="button-action button-warning page-component-minimize" type="button">@icon('minus')</button>
        </div>
        <h3 class="title">{{ $component->name}}</h3>
        <div class="actions-right">
            <button class="button-action page-component-move_up" type="button">@icon('chevron-up')</button>
            <button class="button-action page-component-move_down" type="button">@icon('chevron-down')</button>
        </div>
    </header>
    <section class="page-component-contents">
        <section class="page-component-fields">
            @if ($component->fields !== null && count($component->fields) > 0)
                @foreach ($component->fields as $field)
                    @include('components.field_types')
                @endforeach
            @endif
        </section>
        <section class="page-component-children">
            @if ($component->children !== null && count($component->children) > 0)
                @foreach ($component->children as $component_child)
                    @include('components.show', [
                        'component' => $component_child,
                        'parent_component_id' => $component->id,
                    ])
                @endforeach
            @endif
        </section>
    </section>
    <footer class="page-component-footer">
        <button type="button" class="modal-trigger page-component-add" data-modal="page-modal-pick-component" title="Velg komponent for {{ $component->name}}">
            @icon('package')
            <span>Legg til barnekomponent</span>
        </button>
        <span class="title">{{ $component->name}}</span>
    </footer>
</article>