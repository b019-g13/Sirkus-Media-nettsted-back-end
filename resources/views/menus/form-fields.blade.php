<div class="form-group">
    <label for="form-menu-name">Navn</label>
    <input id="form-menu-name" type="text" name="name" value="{{ old('name', (isset($menu->name) ? $menu->name : null)) }}" required>
</div>

<div class="form-group form-group-switch form-group-switch-yn">
    @php
        $form_menu_global_is_checked = true;
        $old = old('global');

        if ($old === false) {
            $form_menu_global_is_checked = false;
        } else {
            if (isset($menu->global)) {
                if ($menu->global) {
                    $form_menu_global_is_checked = true;
                } else {
                    $form_menu_global_is_checked = false;
                }
            }
        }
    @endphp
    <input id="form-menu-global" type="checkbox" name="global" {{ $form_menu_global_is_checked ? "checked" : null }}>
    <label for="form-menu-global">Skal vises på alle sider?</label>
</div>

<div class="form-group form-group-conditional form-group-conditional-reverse" data-condition-switch="form-menu-global">
    <label for="form-menu-page_id">Vis på en side</label>
    <select id="form-menu-page_id" name="page_id">
        @php
            $old_value = old('page_id', isset($menu->page_id) ? $menu->page_id : null);
        @endphp
        @if ($old_value == null)
            <option value="" hidden selected disabled>Velg en</option>
        @endif
        @foreach ($pages as $page)
            @if ($old_value == $page->id)
                <option value="{{ $page->id }}" selected>{{ $page->title }}</option>
            @else
                <option value="{{ $page->id }}">{{ $page->title }}</option>
            @endif
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="form-menu-menu_location_id">Meny lokasjon</label>
    <select id="form-menu-menu_location_id" name="menu_location_id" required>
        @php
            $old_value = old('menu_location_id', isset($menu->menu_location_id) ? $menu->menu_location_id : null);
        @endphp
        @if ($old_value == null)
            <option value="" hidden selected disabled>Velg en</option>
        @endif
        @foreach ($menu_locations as $menu_location)
            @if ($old_value == $menu_location->id)
                <option value="{{ $menu_location->id }}" selected>{{ $menu_location->name }}</option>
            @else
                <option value="{{ $menu_location->id }}">{{ $menu_location->name }}</option>
            @endif
        @endforeach
    </select>
</div>

<section>
    <h3>Legg til linker i menyen</h3>

    <div id="drag-area-wrapper">
        <p class="heading">Tilgjengelig linker</p>
        <ul class="drag-area drag-area-source">
            <li class="action">
                <button type="button" class="button-blank modal-trigger" data-modal="mymodelyes">
                    <span>Opprett ny</span>
                    @icon('plus-square')
                </button>
            </li>
            @foreach ($links as $link)
                <li class="draggable" data-link_id="{{ $link->id }}">
                    <span class="menu-link-name" title="{{ $link->name }}"><span class="handle"></span>{{ $link->name }}</span>
                </li>
            @endforeach
            @if ($links->count() > 10)
                <li class="action">
                    <button type="button" class="button-blank modal-trigger" data-modal="mymodelyes">
                        <span>Opprett ny</span>
                        @icon('plus-square')
                    </button>
                </li>
            @endif
        </ul>

        <p class="heading">Menyens linker</p>
        <ul class="drag-area drag-area-destination">
            @if (isset($menu->links))
                @foreach ($menu->links as $link)
                    <li class="draggable" data-link_id="{{ $link->id }}">
                        <span class="menu-link-name" title="{{ $link->name }}"><span class="handle"></span>{{ $link->name }}</span>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>

    <input id="drag-area-input" name="links" type="hidden">
</section>
