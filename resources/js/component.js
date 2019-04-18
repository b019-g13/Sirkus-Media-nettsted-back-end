(function() {
    const form = document.querySelector("#form-components");
    const compFieldsWrapper = document.querySelector("#drag-area-wrapper");
    const compFieldsInput = document.querySelector("#drag-area-input");

    // Adds fields in the "Component fields" list to the input
    form.onsubmit = evt => {
        evt.preventDefault();
        let fields = [];

        compFieldsWrapper
            .querySelectorAll(".drag-area-destination .draggable")
            .forEach((field, i) => {
                fields.push({
                    id: field.dataset.field_id,
                    nickname: field.querySelector("input").value,
                    order: i
                });
            });

        compFieldsInput.value = JSON.stringify(fields);
        form.submit();
    };
})();
