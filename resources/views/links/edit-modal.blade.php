<div id="menu-modal-edit-link" class="modal modal-small">
    <header class="modal-header">
        <button type="button" class="button-action button-blank modal-closer">
            @icon('x')
        </button>
        <span class="modal-heading">
            <span>Rediger link</span>
            @icon('load', 'spinner')
        </span>
    </header>
    <section class="modal-body">
        <form action="{{ route('links.update', 'LINK_ID') }}" method="POST">
            @csrf
            @method('patch')
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
<script>
    (function() {
        const form = document.querySelector("#menu-modal-edit-link form");
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
