require("./media-picker");

window.components = {};

// Polyfill for Element.closest for IE9+
(function() {
    if (!Element.prototype.matches) {
        Element.prototype.matches =
            Element.prototype.msMatchesSelector ||
            Element.prototype.webkitMatchesSelector;
    }

    if (!Element.prototype.closest) {
        Element.prototype.closest = function(s) {
            var el = this;

            do {
                if (el.matches(s)) return el;
                el = el.parentElement || el.parentNode;
            } while (el !== null && el.nodeType === 1);
            return null;
        };
    }
})();

// Media pickers
function setupMediaPickers(html) {
    const cfMediaPickers = html.querySelectorAll(".cf-media-picker");

    cfMediaPickers.forEach(cfMediaPicker => {
        const value = cfMediaPicker.dataset.value;
        let img = document.createElement("img");
        img.src = "";

        if (value != null && value.length !== 0) {
            img.src = value;
            cfMediaPicker.classList.add("has-preview");
        }

        cfMediaPicker.appendChild(img);
    });

    let myMediaPicker = new mediaPicker();

    window.addEventListener("media-picker-ready", () => {
        cfMediaPickers.forEach(cfMediaPicker => {
            const triggerOpen = cfMediaPicker.querySelector(".mp-trigger-open");
            const triggerDelete = cfMediaPicker.querySelector(
                ".mp-trigger-delete"
            );
            const outputElement = cfMediaPicker.querySelector("input");
            const previewElement = cfMediaPicker.querySelector("img");

            triggerOpen.addEventListener("click", function() {
                myMediaPicker.functions.setOutputElement(outputElement);
                myMediaPicker.functions.setOutputPreview(previewElement);
                myMediaPicker.functions.show();
            });

            triggerDelete.addEventListener("click", function() {
                cfMediaPicker.classList.remove("has-preview");
                outputElement.value = "";
                previewElement.src = "";
            });
        });
    });
}

// Link pickers
function setupLinkPicker(form) {
    const pickerModal = document.querySelector("#menu-modal-pick-link");
    const pickerForm = pickerModal.querySelector("form");

    const editModalTriggerCheckClass = "menu-link-action-edit-is-setup";
    const deleteModalTriggerCheckClass = "menu-link-action-delete-is-setup";

    setupLinkPickerModals(pickerModal);
    setupLinkPickerOutputs(form);

    function setupLinkPickerOutputs(form) {
        const linkComponents = form.querySelectorAll(
            ".component-field-type-url_external, .component-field-type-url_internal"
        );

        if (linkComponents == null) {
            return;
        }

        linkComponents.forEach(linkComponent => {
            const input = linkComponent.querySelector(".cf-input");
            const outputElement = linkComponent.querySelector(
                ".cf-link-picker-selected"
            );

            if (
                input == null ||
                input.value == null ||
                input.value.length === 0 ||
                outputElement == null
            ) {
                return;
            }

            setupLinkPickerOutputElement(input.value, outputElement);
        });
    }

    pickerForm.addEventListener("submit", function(evt) {
        evt.preventDefault();

        let formData = new FormData(pickerForm);
        const linkId = formData.get("link");

        // Make sure we found a link id, and that the form is connected to a modal,
        // which in turn is connected to the trigger which opened it
        if (
            linkId == null ||
            pickerForm._modal == null ||
            pickerForm._modal._modalTrigger == null
        ) {
            return;
        }

        // Find the input via the modal trigger
        const trigger = pickerForm._modal._modalTrigger;
        const input = trigger.parentNode.querySelector(".cf-input");
        const outputElement = trigger.parentNode.querySelector(
            ".cf-link-picker-selected"
        );

        // Put the link id into the input
        input.value = linkId;

        setupLinkPickerOutputElement(linkId, outputElement);
    });

    function setupLinkPickerOutputElement(linkId, outputElement) {
        // Get the link
        axios.get("/links/" + linkId).then(response => {
            let link = response.data;

            // Make sure element is empty
            while (outputElement.firstChild) {
                outputElement.removeChild(outputElement.firstChild);
            }

            // Create text
            const textValue = link.name + " (" + link.value + ")";
            const textElement = document.createTextNode(textValue);

            // Insert text
            outputElement.appendChild(textElement);
        });
    }

    function setupLinkPickerModals(pickerModal) {
        const editModalTriggers = pickerModal.querySelectorAll(
            ".links .link .link-edit"
        );
        const deleteModalTriggers = pickerModal.querySelectorAll(
            ".links .link .link-delete"
        );

        editModalTriggers.forEach(editModalTrigger => {
            if (
                !editModalTrigger.classList.contains(editModalTriggerCheckClass)
            ) {
                setupLinkPickerEditModal(editModalTrigger);
            }
        });

        deleteModalTriggers.forEach(deleteModalTrigger => {
            if (
                !deleteModalTrigger.classList.contains(
                    deleteModalTriggerCheckClass
                )
            ) {
                setupLinkPickerDeleteModal(deleteModalTrigger);
            }
        });
    }

    function setupLinkPickerEditModal(trigger) {
        trigger.classList.add(editModalTriggerCheckClass);

        // Find modal, form and the link id
        const linkId = trigger.parentNode.dataset.linkId;
        const modalId = trigger.dataset.modal;
        const modal = document.querySelector("#" + modalId);
        const form = modal.querySelector("form");
        const modalLoadingIndicator = modal.querySelector(
            ".modal-heading .spinner"
        );
        let formAction = form.getAttribute("action");

        trigger.addEventListener("click", () => {
            // Edit the form action to use the link id
            if (form.dataset.originalAction) {
                formAction = form.dataset.originalAction;
            } else {
                form.dataset.originalAction = formAction;
            }

            formAction = formAction.replace("LINK_ID", linkId);
            form.setAttribute("action", formAction);

            const inputLinkName = form.querySelector('input[name="name"]');
            const inputLinkInternal = form.querySelector(
                'input[name="internal"]'
            );
            const inputLinkValue = form.querySelector('input[name="value"]');
            const inputLinkPageId = form.querySelector(
                'select[name="page_id"]'
            );

            modalLoadingIndicator.style.display = "inline-block";

            // Get the link
            axios.get(formAction).then(response => {
                let link = response.data;
                modalLoadingIndicator.style.display = "none";

                inputLinkName.value = link.name;
                inputLinkName.setAttribute("value", link.name);

                if (link.page_id == null) {
                    inputLinkValue.value = link.value;
                    inputLinkPageId.value = 0;

                    if (inputLinkInternal.checked) {
                        inputLinkInternal.click();
                    }
                } else {
                    inputLinkPageId.value = link.page_id;
                    inputLinkValue.value = null;

                    if (!inputLinkInternal.checked) {
                        inputLinkInternal.click();
                    }
                }
            });
        });
    }

    function setupLinkPickerDeleteModal(trigger) {
        trigger.classList.add(deleteModalTriggerCheckClass);

        trigger.addEventListener("click", () => {
            // Find modal, form and the link id
            const linkId = trigger.parentNode.dataset.linkId;
            const modalId = trigger.dataset.modal;
            const modal = document.querySelector("#" + modalId);
            const form = modal.querySelector("form");

            // Edit the form action to use the link id
            let formAction = form.getAttribute("action");
            if (form.dataset.originalAction) {
                formAction = form.dataset.originalAction;
            } else {
                form.dataset.originalAction = formAction;
            }

            formAction = formAction.replace("LINK_ID", linkId);
            form.setAttribute("action", formAction);
        });
    }
}

// Component picker
function setupComponentPicker(form) {
    const pickerModal = document.querySelector("#page-modal-pick-component");
    const pickerForm = pickerModal.querySelector("form");
    const componentSuperParent = document.querySelector(
        "#page-component-superparent"
    );

    if (
        pickerModal == null ||
        pickerForm == null ||
        componentSuperParent == null
    ) {
        return;
    }

    const componentGetURL = componentSuperParent.dataset.component_get_url;

    setupComponentRemovers(form);
    setupComponentMinimizers(form);
    setupComponentMaximizers(form);
    setupComponentMoverUp(form);
    setupComponentMoverDown(form);

    pickerForm.addEventListener("submit", evt => {
        evt.preventDefault();

        let formData = new FormData(pickerForm);
        const componentId = formData.get("component");

        // Make sure we found a component id, and that the form is connected to a modal,
        // which in turn is connected to the trigger which opened it
        if (
            componentId == null ||
            pickerForm._modal == null ||
            pickerForm._modal._modalTrigger == null
        ) {
            return;
        }

        // Let's find the output element via the modal trigger
        const outputElementParent =
            pickerForm._modal._modalTrigger.parentNode.parentNode;

        // First set or get an id on the parent element, this is so we can select direct children
        let originalOutputElementParentId = outputElementParent.getAttribute(
            "id"
        );
        if (originalOutputElementParentId === null) {
            outputElementParent.setAttribute(
                "id",
                "component-" + outputElementParent.dataset.component_id
            );
        }

        // Get the output element
        const selector =
            "#" +
            outputElementParent.getAttribute("id") +
            " > .page-component-contents > .page-component-children";
        const outputElement = document.querySelector(selector);

        // If we created an ID for this element, remove it
        if (originalOutputElementParentId === null) {
            outputElementParent.removeAttribute("id");
        }

        // Get HTML for component
        axios
            .get(componentGetURL.replace("COMPONENT_ID", componentId))
            .then(response => {
                // console.log("AXIOS response", response);
                const parsedHTML = new DOMParser().parseFromString(
                    response.data,
                    "text/html"
                );

                // Setup the different action buttons
                setupComponentRemovers(parsedHTML);
                setupComponentMinimizers(parsedHTML);
                setupComponentMaximizers(parsedHTML);
                setupComponentMoverUp(parsedHTML);
                setupComponentMoverDown(parsedHTML);
                setupMediaPickers(parsedHTML);

                parsedHTML.body.childNodes.forEach(child => {
                    outputElement.appendChild(child);
                });

                new setupModalTriggers();
            });
    });
}

function setupComponentVariable(html, parentSelector, parentObject) {
    // Get components
    const components = html.querySelectorAll(
        parentSelector +
            " > .page-component-contents > .page-component-children > .page-component"
    );

    for (let i = 0; i < components.length; i++) {
        const component = components[i];

        if (component.dataset == null) {
            return;
        }

        const componentId = component.dataset.component_id;
        const componentTmpUuid = window.uuid();
        const componentObject = {};

        componentObject.id = componentId;
        componentObject.fields = [];
        componentObject.children = [];
        componentObject.order = i;

        // Set or get an id on the parent element, this is so we can select direct children
        let originalComponentElementId = component.getAttribute("id");
        if (originalComponentElementId === null) {
            component.setAttribute("id", "component-" + componentTmpUuid);
        }

        // Get the component fields
        const componentFields = html.querySelectorAll(
            "#" +
                component.getAttribute("id") +
                " > .page-component-contents > .page-component-fields .component-field"
        );

        for (let j = 0; j < componentFields.length; j++) {
            const componentField = componentFields[j];

            if (componentField.dataset == null) {
                return;
            }

            const componentFieldId = componentField.dataset.component_field_id;
            const fieldType = componentField.dataset.field_type;
            const fieldInput = componentField.querySelector(".cf-input");
            let fieldInputValue = null;

            if (fieldInput !== null) {
                fieldInputValue = fieldInput.value;
            }

            componentObject.fields[j] = {
                component_field_id: componentFieldId,
                order: j,
                type: fieldType,
                value: fieldInputValue
            };
        }

        // Get the component children
        setupComponentVariable(
            html.querySelector(
                "#" +
                    component.getAttribute("id") +
                    " > .page-component-contents > .page-component-children"
            ),
            "#" + component.getAttribute("id"),
            componentObject
        );

        if (parentObject == null) {
            window.components[componentTmpUuid] = componentObject;
        } else {
            parentObject.children.push(componentObject);
        }

        // If we created an ID for this element, remove it
        if (originalComponentElementId === null) {
            component.removeAttribute("id");
        }
    }
}

function setupComponentRemovers(html) {
    const removers = html.querySelectorAll(".page-component-remove");

    removers.forEach(remover => {
        remover.addEventListener("click", function() {
            const child = this.parentNode.parentNode.parentNode;
            const parent = child.parentNode;

            parent.removeChild(child);
        });
    });
}

function setupComponentMinimizers(html) {
    const minimizers = html.querySelectorAll(".page-component-minimize");

    minimizers.forEach(minimizer => {
        minimizer.addEventListener("click", function() {
            const component = this.parentNode.parentNode.parentNode;
            component.classList.add("minimize");
        });
    });
}

function setupComponentMaximizers(html) {
    const maximizers = html.querySelectorAll(".page-component-maximize");

    maximizers.forEach(maximizer => {
        maximizer.addEventListener("click", function() {
            const component = this.parentNode.parentNode.parentNode;
            component.classList.remove("minimize");
        });
    });
}

function setupComponentMoverUp(html) {
    const mover_ups = html.querySelectorAll(".page-component-move_up");

    mover_ups.forEach(mover_up => {
        mover_up.addEventListener("click", function() {
            const child = this.parentNode.parentNode.parentNode;
            const parent = child.parentNode;

            if (child.previousElementSibling === null) {
                return;
            }

            parent.insertBefore(child, child.previousElementSibling);
        });
    });
}

function setupComponentMoverDown(html) {
    const mover_downs = html.querySelectorAll(".page-component-move_down");

    mover_downs.forEach(mover_down => {
        mover_down.addEventListener("click", function() {
            const child = this.parentNode.parentNode.parentNode;
            const parent = child.parentNode;

            if (child.nextElementSibling === null) {
                return;
            }

            parent.insertBefore(child.nextElementSibling, child);
        });
    });
}

// Submit form and setup page
(function() {
    const form = document.querySelector("#form-page");
    const pageComponentsWrapper = document.querySelector("#drag-area-wrapper");
    const pageComponentsInput = document.querySelector(
        "#page-components-input"
    );
    let pageComponentsDestination = document.querySelector(
        "#drag-area-wrapper > .drag-area-destination"
    );

    setupComponentPicker(form);

    setupLinkPicker(form);
    setupMediaPickers(form); // TODO: Stop duplication

    form.onsubmit = evt => {
        evt.preventDefault();

        setupComponentVariable(form, "#page-component-superparent");

        pageComponentsInput.value = JSON.stringify(window.components);

        form.submit();
    };
})();
