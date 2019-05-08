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
<script>
    (function() {
        const form = document.querySelector("#menu-modal-delete-link form");
        form.addEventListener("submit", evt => {
            evt.preventDefault();

            const url = form.action;
            const data = new FormData(form);
            const config = {
                headers: {
                    "Content-Type": "application/json"
                },
                transformRequest: [function(data) {
                    newData = {};
                    data.forEach((value, key) => {newData[key] = value});
                    return JSON.stringify(newData);
                }]
            };
            
            axios.post(url, data, config);
        });
    })();
</script>