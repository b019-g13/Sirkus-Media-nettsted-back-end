require("./media-picker");

function cfSetupMediaPickers(form) {
    const mediaPickers = form.querySelectorAll(".cf-media-picker");

    console.log("setup media picker");

    const mediaPickerView = axios
        .get("/media-picker")
        .then(function(response) {
            // handle success
            console.log(response);
            document.body.insertAdjacentHTML("beforeend", response.data);
            window.setupMediaPicker();
            window.mediaPicker.show();
        })
        .catch(function(error) {
            // handle error
            console.log(error);
        })
        .then(function() {
            // always executed
            console.log("setup media picker - executed");
        });

    console.log(mediaPickerView);

    mediaPickers.forEach(mediaPicker => {
        cfSetupMediaPicker(mediaPicker);
    });
}

(function() {
    const form = document.querySelector("#form-page");
    const pageComponentsWrapper = document.querySelector("#drag-area-wrapper");
    const pageComponentsInput = document.querySelector("#drag-area-input");

    cfSetupMediaPickers(form);

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

        console.log(pageComponentsInputValue);
        pageComponentsInput.value = JSON.stringify(pageComponentsInputValue);
        pageComponentsWrapper.appendChild(
            document.createTextNode(JSON.stringify(pageComponentsInputValue))
        );
        // form.submit();
    };
})();

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

            console.log("push", inputField, value);

            fields.push({
                id: field.dataset.field_id,
                type: field.dataset.field_type,
                order: i,
                value: value
            });
        } else {
            console.log("null!");
        }
    });

    return fields;
}

function getChildren(component, order) {
    console.log(component);
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
