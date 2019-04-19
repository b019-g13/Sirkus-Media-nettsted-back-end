<div id="mymodelyes" class="modal modal-small">
    <header class="modal-header">
        <button type="button" class="button-action button-blank modal-closer">
            @icon('x')
        </button>
        <span class="modal-heading">Lag en link</span>
    </header>
    <section class="modal-body">
        <form action="{{ route('links.store') }}" method="POST">
            @csrf
            @include('links.form-fields')
        </form>
    </section>
    <footer class="modal-footer">
        <button type="button" class="button-blank modal-closer">
            @icon('x')
            <span>Avbryt</span>
        </button>
        <button type="button" class="button-success modal-submit">
            @icon('save')
            <span>Lagre</span>
        </button>
    </footer>
    <div class="modal-spacer"></div>
</div>
