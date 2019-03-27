// eslint-disable-next-line import/no-unresolved
import { Sortable } from "@shopify/draggable";

(function() {
    const containers = document.querySelectorAll(
        "#component-fields-drag .component-fields"
    );

    const originalDragElementClasses = "draggable component-field";

    if (containers.length === 0) {
        return false;
    }

    const sortable = new Sortable(containers, {
        draggable: ".draggable"
    });

    let sourceList = sortable.containers[0];
    let destinationList = sortable.containers[1];

    sortable.on("sortable:stop", evt => {
        // Make copy of node we dropped into destination list
        if (
            evt.oldContainer === sourceList &&
            evt.newContainer === destinationList
        ) {
            let activeDragElementCopy = evt.dragEvent.source.cloneNode(true);

            evt.oldContainer.insertBefore(
                activeDragElementCopy,
                evt.dragEvent.originalSource
            );

            activeDragElementCopy.classList = originalDragElementClasses;
            activeDragElementCopy.style.display = "";
        } else if (
            evt.newContainer === sourceList &&
            evt.oldContainer === destinationList
        ) {
            // Hide the node we dropped into source list (Can't be removed...)
            evt.dragEvent.originalSource.classList.add("hide");
        }
    });

    return sortable;
})();
