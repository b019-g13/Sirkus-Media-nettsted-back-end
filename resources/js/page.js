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
