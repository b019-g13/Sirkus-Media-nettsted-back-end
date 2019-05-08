<div id="menu-modal-pick-link" class="modal modal-medium">
    <header class="modal-header">
        <button type="button" class="button-action button-blank modal-closer">
            @icon('x')
        </button>
        <span class="modal-heading">Velg en link</span>
    </header>
    <section class="modal-body links">
        @php
            $unique_modal_id = 'modal-' . md5(uniqid(rand(), true));
        @endphp
        <button type="button" class="button-blank link-create modal-trigger" data-modal="menu-modal-create-link">
            @icon('plus-square')
            <span>Opprett ny</span>
        </button>

        <form method="get" action="">
            {{-- Named $_link to avoid filling out the form-fields view of the included modals --}}
            @foreach ($links as $_link)
                @php
                    $unique_link_id = 'link-' . md5(uniqid(rand(), true));
                @endphp
                <article class="link" data-link-id="{{ $_link->id }}">
                    <input class="link-select" type="radio" name="link" id="{{ $unique_link_id }}" value="{{ $_link->id }}" required>
                    <label class="link-name" for="{{ $unique_link_id }}" class="link-label">{{ $_link->name }}</label>
                    <label class="link-value" for="{{ $unique_link_id }}" class="link-value">({{ $_link->value }})</label>
                    <button class="modal-trigger button-action button-blank link-edit" type="button" data-modal="menu-modal-edit-link">
                        @icon('edit')
                    </button>
                    <button class="modal-trigger button-action button-blank link-delete" type="button" data-modal="menu-modal-delete-link">
                        @icon('x')
                    </button>
                </article>
            @endforeach
        </form>
        @if ($links->count() > 10)
            <button type="button" class="button-blank link-create modal-trigger" data-modal="menu-modal-create-link">
                @icon('plus-square')
                <span>Opprett ny</span>
            </button>
        @endif
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
@include('links.create-modal')
@include('links.edit-modal')
@include('links.delete-modal')
