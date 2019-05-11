<div id="page-modal-pick-component" class="modal modal-large">
    <header class="modal-header">
        <button type="button" class="button-action button-blank modal-closer">
            @icon('x')
        </button>
        <span class="modal-heading">Velg en komponent</span>
    </header>
    <section class="modal-body">
        @php
            $unique_modal_id = 'modal-' . md5(uniqid(rand(), true));
        @endphp
        <form method="get" action="">
            <ul>
                @foreach ($components as $component)
                    <li>
                        @include('components.pick-modal-single')
                    </li>
                @endforeach
            </ul>
        </form>
    </section>
    <footer class="modal-footer">
        <button type="button" class="button-blank modal-closer">
            @icon('x')
            <span>Avbryt</span>
        </button>
        <button type="button" class="button-success modal-submit">
            @icon('save')
            <span>Velg</span>
        </button>
    </footer>
    <div class="modal-spacer"></div>
</div>
