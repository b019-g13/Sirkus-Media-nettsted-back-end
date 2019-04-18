require("./media-picker");

function cfSetupMediaPicker(wrapper) {
    const outputElement = wrapper.querySelector(".cf-input");
    // outputElement.value = "Funker 👌👌👌";
}

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

function getChildren(component, order) {
    if (component == null) {
        return [];
    }

    let componentId = component.getAttribute("id");
    if (componentId == null) {
        componentId =
            "page-component-draggable-loop-current-child-" +
            component.dataset.component_id;
        component.setAttribute("id", componentId);
    }

    const componentChildren = document.querySelectorAll(
        "#" + componentId + " > .page-component"
    );

    component.removeAttribute("id");

    let output = {
        id: component.dataset.component_id,
        order: order,
        fields: getFields(component),
        children: []
    };

    if (componentChildren.length !== 0) {
        componentChildren.forEach((componentChild, i) => {
            output.children.push(getChildren(componentChild, i));
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

function setupChildAdder(component_original) {
    // Make a clone of the component and append it
    const component_clone = component_original.cloneNode(true);
    component_original.parentNode.appendChild(component_clone);

    // Setup the cloned duplicator button
    const button_clone_duplicate = component_clone.querySelector(
        ".page-component-duplicate"
    );
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

function setupChildRemovers(form) {
    const buttons = form.querySelectorAll(".page-component-remove");

    buttons.forEach(button => {
        button.addEventListener("click", () => {
            setupChildRemover(button.parentNode.parentNode);
        });
    });
}

function setupChildRemover(component) {
    component.parentNode.removeChild(component);
}

function setupChildAdders(form) {
    const buttons = form.querySelectorAll(".page-component-duplicate");

    buttons.forEach(button => {
        button.addEventListener("click", () => {
            setupChildAdder(button.parentNode.parentNode);
        });
    });
}

(function() {
    const form = document.querySelector("#form-page");
    const pageComponentsWrapper = document.querySelector("#drag-area-wrapper");
    const pageComponentsInput = document.querySelector("#drag-area-input");

    setupMediaPickers(form);
    setupChildAdders(form);
    setupChildRemovers(form);

    // Adds Components in the "page components" list to the input
    form.onsubmit = evt => {
        evt.preventDefault();
        let pageComponentsInputValue = [];

        pageComponentsWrapper
            .querySelectorAll(".drag-area-destination .draggable")
            .forEach((component, i) => {
                let componentId = component.getAttribute("id");
                if (componentId == null) {
                    componentId =
                        "page-component-draggable-loop-current-parent";
                    component.setAttribute("id", componentId);
                }

                pageComponentsInputValue.push({
                    id: component.dataset.component_id,
                    order: i,
                    name: document.querySelector(
                        "#" + componentId + "> .page-component > .heading"
                    ).innerHTML,
                    fields: getFields(
                        document.querySelector(
                            "#" + componentId + "> .page-component"
                        )
                    ),
                    children: getChildren(
                        document.querySelector(
                            "#" + componentId + "> .page-component"
                        ),
                        i
                    ).children
                });

                component.removeAttribute("id");
            });

        pageComponentsInput.value = JSON.stringify(pageComponentsInputValue);
        form.submit();
    };
})();
