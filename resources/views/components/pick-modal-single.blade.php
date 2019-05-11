@include('components.pick-modal-single-content')

@if ($component->children->count() > 0)
    <ul>
        @foreach ($component->children as $child_component)
            @include('components.pick-modal-single', ['component' => $child_component])
        @endforeach
    </ul>
@endif