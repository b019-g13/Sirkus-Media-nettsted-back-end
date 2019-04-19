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
    const eventDragNewItem = new CustomEvent("draggable-drag-new-item");
    const dragAreasWrapper = document.querySelector("#drag-area-wrapper");

    // No drag area wrapper on this page
    if (dragAreasWrapper == null) {
        return false;
    }

    let dragAreaContainers = dragAreasWrapper.querySelectorAll(".drag-area");

    // No drag areas on this page
    if (dragAreaContainers == null) {
        return false;
    }

    let availableItemsContainer = dragAreasWrapper.querySelector(
        ".drag-area-source"
    );
    let activeItemsContainers = dragAreasWrapper.querySelectorAll(
        ".drag-area-destination"
    );

    // No drag area source or destinations on this page
    if (availableItemsContainer == null || activeItemsContainers == null) {
        return false;
    }

    let sortable = new Sortable(dragAreaContainers, {
        draggable: ".draggable"
    });

    sortable.on("sortable:stop", evt => {
        // Make copy of node we dropped into destination list
        if (
            evt.oldContainer === availableItemsContainer &&
            Array.prototype.indexOf.call(
                activeItemsContainers,
                evt.newContainer
            ) >= 0
        ) {
            let activeDragElementCopy = evt.dragEvent.source.cloneNode(true);
            let activeDragElementOriginal = evt.dragEvent.originalSource;

            evt.oldContainer.insertBefore(
                activeDragElementCopy,
                evt.dragEvent.originalSource
            );

            activeDragElementCopy.classList = "draggable";
            activeDragElementOriginal.style.display = "";

            const inputs = activeDragElementCopy.querySelectorAll(
                "input, textarea"
            );

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

            setTimeout(() => {
                dispatchEvent(eventDragNewItem);
            }, 200);
        } else if (
            evt.newContainer === availableItemsContainer &&
            Array.prototype.indexOf.call(
                activeItemsContainers,
                evt.oldContainer
            ) >= 0
        ) {
            // Hide the node we dropped into source list (Can't be removed...)
            evt.dragEvent.originalSource.classList.add("hide");
        }
    });

    return sortable;
})();

// Conditional form elements
(function() {
    let conditionalSwitches = {};
    const conditionals = document.querySelectorAll(".form-group-conditional");

    conditionals.forEach(conditional => {
        const conditionalSwitchId = conditional.dataset.conditionSwitch;
        const conditionalSwitch = document.querySelector(
            "#" + conditionalSwitchId
        );

        if (!conditionalSwitch.dataset.switchId) {
            conditionalSwitch.dataset.switchId = uuidv4();
        }
        const randomId = conditionalSwitch.dataset.switchId;

        if (conditionalSwitches[randomId]) {
            conditionalSwitches[randomId].conditionals.push(conditional);
        } else {
            conditionalSwitches[randomId] = {
                switch: conditionalSwitch,
                conditionals: [conditional]
            };
        }
    });

    Object.keys(conditionalSwitches).forEach(function(key) {
        const conditionalSwitch = conditionalSwitches[key];

        if (conditionalSwitch.switch.checked) {
            toggleConditionals(conditionalSwitch.conditionals);
        }

        conditionalSwitch.switch.addEventListener("change", () => {
            toggleConditionals(conditionalSwitch.conditionals);
        });
    });

    function toggleConditionals() {
        conditionals.forEach(conditional => {
            conditional.classList.toggle("form-group-conditional-active");
        });
    }
})();

(function() {
    let lastFocusedElement = document.body;
    const modalTriggers = document.querySelectorAll(".modal-trigger");
    const modalCloserCheckClass = "modal-closer-is-setup";
    const modalSubmitterCheckClass = "modal-submitter-is-setup";

    if (modalTriggers == null) {
        return false;
    }

    // Setup modal openers
    modalTriggers.forEach(modalTrigger => {
        const modalId = modalTrigger.dataset.modal;
        const modal = document.querySelector("#" + modalId);

        if (modal != null) {
            modalTrigger.addEventListener("click", () => {
                openModal(modal);
            });

            // Setup modal closers
            const modalClosers = modal.querySelectorAll(".modal-closer");
            modalClosers.forEach(modalCloser => {
                if (!modalCloser.classList.contains(modalCloserCheckClass)) {
                    modalCloser.classList.add(modalCloserCheckClass);

                    modalCloser.addEventListener("click", () => {
                        closeModal(modal);
                    });
                }
            });

            // Setup modal submitters
            const modalSubmitters = modal.querySelectorAll(".modal-submit");
            modalSubmitters.forEach(modalSubmitter => {
                if (
                    !modalSubmitter.classList.contains(modalSubmitterCheckClass)
                ) {
                    modalSubmitter.classList.add(modalSubmitterCheckClass);

                    modalSubmitter.addEventListener("click", () => {
                        submitModal(modal);
                    });
                }
            });
        }
    });

    function openModal(modal) {
        if (modal == null) {
            return false;
        }

        modal.classList.add("modal-open");
        document.documentElement.classList.add("modal-open");

        lastFocusedElement = document.activeElement;
        modal.setAttribute("tabindex", 0);
        modal.focus();
    }

    function closeModal(modal) {
        if (modal == null) {
            return false;
        }

        modal.classList.remove("modal-open");
        document.documentElement.classList.remove("modal-open");
        lastFocusedElement.focus();
    }

    function submitModal(modal) {
        if (modal == null) {
            return false;
        }

        closeModal(modal);

        const form = modal.querySelector("form");
        form.submit();
    }
})();
