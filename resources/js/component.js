(function() {
    const form = document.querySelector("#form-components");
    const compFieldsWrapper = document.querySelector("#component-fields-drag");
    const compFieldsInput = document.querySelector("#component-fields-input");

    // Adds fields in the "Component fields" list to the input
    form.onsubmit = evt => {
        evt.preventDefault();
        let fields = "";

        compFieldsWrapper
            .querySelectorAll(".component-fields-destination .component-field")
            .forEach(field => {
                fields += field.dataset.field_id + ",";
            });

        compFieldsInput.value = fields.substr(0, fields.length - 1);

        form.submit();
    };
})();
