// eslint-disable-next-line import/no-unresolved
import { Sortable } from "@shopify/draggable";

function uuidv4() {
    return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
        (
            c ^
            (crypto.getRandomValues(new Uint8Array(1))[0] & (15 >> (c / 4)))
        ).toString(16)
    );
}

// Load Axios and set CSRF token
window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

// Setup draggable
(function() {
    const containers = document.querySelectorAll(
        "#drag-area-wrapper .drag-area"
    );

    const originalDragElementClasses = "draggable";

    if (containers.length === 0) {
        return false;
    }

    const sortable = new Sortable(containers, {
        draggable: ".draggable"
    });

    let sourceList = sortable.containers[0];
    let destinationList = sortable.containers[1];

    sortable.on("sortable:stop", evt => {
        // Make copy of node we dropped into destination list
        if (
            evt.oldContainer === sourceList &&
            evt.newContainer === destinationList
        ) {
            let activeDragElementOriginal = evt.dragEvent.source.cloneNode(
                true
            );
            let activeDragElementCopy = evt.dragEvent.originalSource;

            evt.oldContainer.insertBefore(
                activeDragElementOriginal,
                evt.dragEvent.originalSource
            );

            activeDragElementOriginal.classList = originalDragElementClasses;
            activeDragElementOriginal.style.display = "";

            const inputs = activeDragElementCopy.querySelectorAll("input");

            if (inputs != null) {
                inputs.forEach(input => {
                    const uuid = uuidv4();
                    input.setAttribute("id", "input-" + uuid);

                    const label = input.parentNode.querySelector("label");
                    if (label != null) {
                        label.setAttribute("for", "input-" + uuid);
                    }
                });
            }
        } else if (
            evt.newContainer === sourceList &&
            evt.oldContainer === destinationList
        ) {
            // Hide the node we dropped into source list (Can't be removed...)
            evt.dragEvent.originalSource.classList.add("hide");
        }
    });

    return sortable;
})();
