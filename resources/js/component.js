(function() {
    const form = document.querySelector("#form-components");
    const compFieldsWrapper = document.querySelector("#component-fields-drag");
    const compFieldsInput = document.querySelector("#component-fields-input");

    // Adds fields in the "Component fields" list to the input
    form.onsubmit = evt => {
        evt.preventDefault();
        let fields = [];

        compFieldsWrapper
            .querySelectorAll(".component-fields-destination .component-field")
            .forEach((field, i) => {
                fields.push({
                    id: field.dataset.field_id,
                    order: i
                });
            });

        compFieldsInput.value = JSON.stringify(fields);
        form.submit();
    };
})();
