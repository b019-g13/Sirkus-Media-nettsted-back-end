<div id="menu-modal-delete-link" class="modal modal-small">
    <form action="{{ route('links.destroy', 'LINK_ID') }}" method="POST">
        @csrf
        @method('delete')
    </form>
    <header class="modal-header">
        <button type="button" class="button-action button-blank modal-closer">
            @icon('x')
        </button>
        <span class="modal-heading">Slett link</span>
    </header>
    <section class="modal-body">
        <p>Er du sikker på at du vil slette linken?</span>
    </section>
    <footer class="modal-footer">
        <button type="button" class="button-blank modal-closer">
            @icon('x')
            <span>Nei, avbryt</span>
        </button>
        <button type="button" class="button-error modal-submit">
            @icon('x')
            <span>Ja, slett</span>
        </button>
    </footer>
    <div class="modal-spacer"></div>
</div>
