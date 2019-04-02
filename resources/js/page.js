(function() {
    const form = document.querySelector("#form-page");
    const pageComponentsWrapper = document.querySelector("#drag-area-wrapper");
    const pageComponentsInput = document.querySelector("#drag-area-input");

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
        componentFields.forEach(field => {
            let inputField = field.querySelector("input");

            if (inputField == null) {
                inputField = field.querySelector("textarea");
            }

            const value = inputField.value;

            fields.push({
                id: field.dataset.field_id,
                value: value
            });
        });

        return fields;
    }

    function getChildren(component) {
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
            fields: getFields(component),
            children: []
        };

        if (componentChildren.length !== 0) {
            componentChildren.forEach(componentChild => {
                output.children.push(getChildren(componentChild));
            });
        }

        return output;
    }

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
                        )
                    ).children
                });

                component.removeAttribute("id");
            });

        console.log(pageComponentsInputValue);
        pageComponentsInput.value = JSON.stringify(pageComponentsInputValue);
        pageComponentsWrapper.appendChild(
            document.createTextNode(JSON.stringify(pageComponentsInputValue))
        );
        form.submit();
    };
})();
