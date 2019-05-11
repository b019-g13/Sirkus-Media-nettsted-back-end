<article class="page-component page-component--{{ $component->slug }}" data-component_id="{{ $component->id }}">
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
            @foreach ($component->fields as $field)
                @include('components.field_types')
            @endforeach
        </section>
        <section class="page-component-children"></section>
    </section>
    <footer class="page-component-footer">
        <button type="button" class="modal-trigger page-component-add" data-modal="page-modal-pick-component" title="Velg komponent for {{ $component->name}}">
            @icon('package')
            <span>Legg til barnekomponent</span>
        </button>
        <span class="title">{{ $component->name}}</span>
    </footer>
</article>