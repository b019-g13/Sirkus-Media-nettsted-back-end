(function() {
    const form = document.querySelector("#form-menu");
    const menuLinksWrapper = document.querySelector("#drag-area-wrapper");
    const menuLinksInput = document.querySelector("#drag-area-input");

    console.log(form);

    // Adds links in the "menu links" list to the input
    form.onsubmit = evt => {
        evt.preventDefault();
        let links = [];

        menuLinksWrapper
            .querySelectorAll(".drag-area-destination .draggable")
            .forEach((link, i) => {
                links.push({
                    id: link.dataset.link_id,
                    // nickname: link.querySelector("input").value,
                    order: i
                });
            });

        menuLinksInput.value = JSON.stringify(links);
        form.submit();
    };
})();
