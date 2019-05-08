require("./media-picker");

function getFields(component) {
    let componentId = component.getAttribute("id");
    if (componentId == null) {
        componentId =
            "page-component-draggable-loop-current-field" +
            component.dataset.component_id;
        component.setAttribute("id", componentId);
    }

    const componentFields = document.querySelectorAll(
        "#" + componentId + " > .component-field"
    );

    component.removeAttribute("id");

    let fields = [];
    componentFields.forEach((field, i) => {
        let inputField = field.querySelector(".cf-input");
        if (inputField != null) {
            const value = inputField.value;

            fields.push({
                component_field_id: field.dataset.component_field_id,
                type: field.dataset.field_type,
                order: i,
                value: value
            });
        } else {
            console.error("null!");
        }
    });

    return fields;
}

function getChildren(parent, order) {
    let output = [];

    if (parent == null) {
        return output;
    }

    let parentId = parent.getAttribute("id");
    if (parentId == null) {
        parentId =
            "page-component-draggable-loop-current-child-" +
            parent.dataset.component_id;
        parent.setAttribute("id", parentId);
    }

    const componentChildren = document.querySelectorAll(
        "#" +
            parentId +
            " > .page-component > .drag-area > .draggable > .page-component"
    );

    parent.removeAttribute("id");

    if (componentChildren.length !== 0) {
        componentChildren.forEach((componentChild, i) => {
            output.push({
                id: componentChild.dataset.component_id,
                parent_id: parent.dataset.component_id,
                order: order,
                fields: getFields(componentChild),
                children: getChildren(componentChild.parentNode, i)
            });
        });
    }

    return output;
}

function setupMediaPickers(form) {
    const cfMediaPickers = form.querySelectorAll(".cf-media-picker");

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

            // inputLinkName.value = " ";
            // inputLinkValue.value = null;
            // inputLinkPageId.value = null;
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

function setupChildAdders(wrapper) {
    const buttons = wrapper.querySelectorAll(".page-component-duplicate");
    const checkClass = "button-has-been-setup-child-adder";

    buttons.forEach(button => {
        if (!button.classList.contains(checkClass)) {
            button.classList.add(checkClass);
            button.classList.add("ready");

            button.addEventListener("click", () => {
                setupChildAdder(button.parentNode.parentNode.parentNode);
            });
        }
    });
}

function setupChildAdder(component_original) {
    // Make a clone of the component and append it
    const component_clone = component_original.cloneNode(true);
    component_original.parentNode.appendChild(component_clone);

    // Setup the cloned duplicator button
    const button_clone_duplicate = component_clone.querySelector(
        ".page-component-duplicate"
    );
    button_clone_duplicate.classList.add("button-has-been-setup-child-adder");
    button_clone_duplicate.addEventListener("click", () => {
        setupChildAdder(component_clone);
    });

    // Setup the cloned remover button
    const button_clone_remove = component_clone.querySelector(
        ".page-component-remove"
    );
    button_clone_remove.addEventListener("click", () => {
        setupChildRemover(component_clone);
    });
}

function setupChildRemovers(wrapper) {
    const buttons = wrapper.querySelectorAll(".page-component-remove");
    const checkClass = "has-been-setup-child-remove";

    buttons.forEach(button => {
        if (!button.classList.contains(checkClass)) {
            button.classList.add(checkClass);
            button.classList.add("ready");

            button.addEventListener("click", () => {
                setupChildRemover(button.parentNode.parentNode.parentNode);
            });
        }
    });
}

function setupChildRemover(component) {
    component.parentNode.removeChild(component);
}

(function() {
    const form = document.querySelector("#form-page");
    const pageComponentsWrapper = document.querySelector("#drag-area-wrapper");
    const pageComponentsInput = document.querySelector("#drag-area-input");
    let pageComponentsDestination = document.querySelector(
        "#drag-area-wrapper > .drag-area-destination"
    );

    setupLinkPicker(form);
    setupMediaPickers(form);
    setupChildAdders(pageComponentsDestination);
    setupChildRemovers(pageComponentsDestination);

    // When the draggable event fires, lets set up the duplicate and remove buttons
    window.addEventListener("draggable-drag-new-item", () => {
        setupChildAdders(pageComponentsDestination);
        setupChildRemovers(pageComponentsDestination);
    });

    // Adds Components in the "page components" list to the input
    form.onsubmit = evt => {
        evt.preventDefault();
        let pageComponentsInputValue = [];

        document
            .querySelectorAll(
                "#" +
                    pageComponentsWrapper.getAttribute("id") +
                    " > .drag-area-destination > .draggable"
            )
            .forEach((component, i) => {
                let componentId = component.getAttribute("id");
                if (componentId == null) {
                    componentId =
                        "page-component-draggable-loop-current-parent";
                    component.setAttribute("id", componentId);
                }

                pageComponentsInputValue.push({
                    id: document.querySelector(
                        "#" + componentId + "> .page-component"
                    ).dataset.component_id,
                    order: i,
                    parent_id: null,
                    name: document.querySelector(
                        "#" + componentId + "> .page-component > .heading"
                    ).innerHTML,
                    fields: getFields(
                        document.querySelector(
                            "#" + componentId + "> .page-component"
                        )
                    ),
                    children: getChildren(component, i)
                });

                component.removeAttribute("id");
            });

        pageComponentsInput.value = JSON.stringify(pageComponentsInputValue);
        form.submit();
    };
})();
