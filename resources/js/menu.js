(function() {
    const form = document.querySelector("#form-menu");
    const menuLinksWrapper = document.querySelector("#drag-area-wrapper");
    const menuLinksInput = document.querySelector("#drag-area-input");
    const editModalTriggerCheckClass = "menu-link-action-edit-is-setup";
    const deleteModalTriggerCheckClass = "menu-link-action-delete-is-setup";

    setupMenuLinkModals();
    window.addEventListener("draggable-drag-new-item", setupMenuLinkModals);

    function setupMenuLinkModals() {
        const editModalTriggers = document.querySelectorAll(
            ".menu-link-action-edit"
        );
        const deleteModalTriggers = document.querySelectorAll(
            ".menu-link-action-delete"
        );

        editModalTriggers.forEach(editModalTrigger => {
            if (
                !editModalTrigger.classList.contains(editModalTriggerCheckClass)
            ) {
                setupMenuLinkEditModal(editModalTrigger);
            }
        });

        deleteModalTriggers.forEach(deleteModalTrigger => {
            if (
                !deleteModalTrigger.classList.contains(
                    deleteModalTriggerCheckClass
                )
            ) {
                setupMenuLinkDeleteModal(deleteModalTrigger);
            }
        });
    }

    function setupMenuLinkEditModal(trigger) {
        trigger.classList.add(editModalTriggerCheckClass);

        trigger.addEventListener("click", () => {
            // Find modal, form and the link id
            const linkId = trigger.parentNode.parentNode.dataset.linkId;
            const modalId = trigger.dataset.modal;
            const modal = document.querySelector("#" + modalId);
            const form = modal.querySelector("form");
            const modalLoadingIndicator = modal.querySelector(
                ".modal-heading .spinner"
            );

            // Edit the form action to use the link id
            let formAction = form.getAttribute("action");
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

            inputLinkName.value = " ";
            inputLinkValue.value = null;
            inputLinkPageId.value = null;
            modalLoadingIndicator.style.display = "inline-block";

            // Get the link
            axios.get(formAction).then(response => {
                let link = response.data;
                modalLoadingIndicator.style.display = "none";

                inputLinkName.value = link.name;

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

    function setupMenuLinkDeleteModal(trigger) {
        trigger.classList.add(deleteModalTriggerCheckClass);
    }

    // Adds links in the "menu links" list to the input
    form.onsubmit = evt => {
        evt.preventDefault();
        let links = [];

        menuLinksWrapper
            .querySelectorAll(".drag-area-destination .draggable")
            .forEach((link, i) => {
                links.push({
                    id: link.dataset.linkId,
                    // nickname: link.querySelector("input").value,
                    order: i
                });
            });

        menuLinksInput.value = JSON.stringify(links);
        form.submit();
    };
})();
