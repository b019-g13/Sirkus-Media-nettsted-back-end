// polyfill for custom events for IE
(function() {
    if (typeof window.CustomEvent === "function") return false;

    function CustomEvent(event, params) {
        params = params || {
            bubbles: false,
            cancelable: false,
            detail: undefined
        };
        var evt = document.createEvent("CustomEvent");
        evt.initCustomEvent(
            event,
            params.bubbles,
            params.cancelable,
            params.detail
        );
        return evt;
    }

    CustomEvent.prototype = window.Event.prototype;

    window.CustomEvent = CustomEvent;
})();

window.mediaPicker = function() {
    // Inside different scopes using 'this' wont give you the class,
    // so we make a variable for it so that we can always reach it.
    // const _this = this;
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    this.name = "mediaPicker";
    this.visibility = "hidden";
    this.element = null;
    this.ready = false;
    this.mediaLoaded = false;
    this.elements = {
        activeMedium: null // Contains the selected input (radio button)
    };
    this.functions = {};
    this.events = {};

    this.events.ready = new CustomEvent("media-picker-ready");

    // Loads the HTML for the media picker
    this.functions.loadViewIntoDocument = () => {
        window.axios
            .get("/media-picker")
            .then(response => {
                document.body.insertAdjacentHTML("beforeend", response.data);

                this.element = document.querySelector("#media-picker");
            })
            .catch(error => {
                console.error(error);
            })
            .then(() => {
                this.elements.form = this.element.parentNode;

                if (this.elements.form == null) {
                    console.error("Couldn't find the media picker's form");
                    return;
                }

                this.functions.setupSubmitButton();
                this.functions.setupCloseButtons();
                this.functions.setupUploadButton();
                this.functions.setupDeleteButton();
                this.functions.setupMediaChangeEvent();

                this.elements.form.addEventListener(
                    "submit",
                    this.functions.submit
                );

                // Everything should be ready
                dispatchEvent(this.events.ready);
                this.ready = true;
            });
    };

    this.functions.refreshView = () => {
        const url = this.elements.form.dataset.action_refresh;

        window.axios
            .get(url)
            .then(response => {
                const mediaPickerBody = this.elements.form.querySelector(
                    ".media-picker-body"
                );

                // Remove all existing element, but keep the preview element
                while (
                    mediaPickerBody.lastElementChild !== null &&
                    ![
                        "media-picker-medium-preview-radio",
                        "media-picker-upload-preview"
                    ].includes(
                        mediaPickerBody.lastElementChild.getAttribute("id")
                    )
                ) {
                    mediaPickerBody.removeChild(
                        mediaPickerBody.lastElementChild
                    );
                }

                // Parse the HTML in the response
                const parsedHTML = new DOMParser().parseFromString(
                    response.data,
                    "text/html"
                );

                // Append the parsed HTML to the media picker body
                parsedHTML.body.childNodes.forEach(child => {
                    mediaPickerBody.appendChild(child);
                });

                this.functions.loadMedia();
                this.functions.setupMediaChangeEvent();

                // Hide the preview
                this.elements.uploadPreview.parentNode.style.display = "none";

                // Select the newly uploaded media
                this.elements.uploadPreview.parentNode.nextElementSibling.click();
            })
            .catch(error => {
                console.log("Couldn't refresh media picker", error);
            })
            .then(() => {
                this.functions.disableLoadingMode();
            });
    };

    // Triggers when user selected a different medium
    this.functions.mediaChange = evt => {
        this.elements.deleteButton.style.display = "inline-block";
        this.activeMedium = evt.target;
    };

    // Makes sure activeMedium is always the selected input (radio button)
    this.functions.setupMediaChangeEvent = () => {
        this.elements.media = this.element.querySelectorAll(
            ".media-picker-medium-input"
        );
        this.elements.media.forEach(medium => {
            if (medium.checked) {
                this.activeMedium = medium;
            }
            medium.addEventListener("change", this.functions.mediaChange);
        });
    };

    // Allows for showing the media picker by pressing spacebar og return (enter)
    this.functions.showWithEnterOrSpace = evt => {
        if (evt.key === "Enter" || evt.key === " ") {
            this.functions.show();
        }
    };

    // Show the media picker
    this.functions.show = evt => {
        this.element.classList.remove("hide");
        this.element.classList.add("show");

        if (!this.mediaLoaded) {
            this.functions.loadMedia();
        }

        this.events.escapeKeyUp = window.addEventListener(
            "keyup",
            this.functions.hideWithEsc
        );

        this.visibility = "showing";
        document.body.style.overflow = "hidden";

        if (this.activeMedium != null) {
            this.elements.deleteButton.style.display = "inline-block";
        }
    };

    this.functions.loadMedia = () => {
        const mediaElements = this.element.querySelectorAll(
            ".media-picker-medium img"
        );

        mediaElements.forEach(mediumElement => {
            if (mediumElement.dataset.url != null) {
                mediumElement.src = mediumElement.dataset.url;
            }
        });

        this.mediaLoaded = true;
    };

    // Allow for hiding the media picker by pressing escape
    this.functions.hideWithEsc = evt => {
        if (evt.key === "Escape") {
            this.functions.hide();
        }
    };

    // Hide the media picker
    this.functions.hide = () => {
        this.element.classList.remove("show");
        this.element.classList.add("hide");

        // Remove the escape keypress event so it doesn't bubble
        window.removeEventListener("keyup", this.functions.hideWithEsc);

        this.visibility = "hidden";

        document.body.style.overflow = "";
        this.elements.deleteButton.style.display = "none";
    };

    // Toggle the visibility of media picker
    this.functions.toggle = () => {
        if (this.visibility === "hidden") {
            this.functions.show();
        } else {
            this.functions.hide();
        }
    };

    // Submit. Sends the value of the selected input (radio button) to the input outside of the media picker
    this.functions.submit = evt => {
        evt.preventDefault();

        // Set preview outside of the media picker
        if (this.elements.outputPreview != null) {
            if (this.activeMedium.dataset.preview === "") {
                this.elements.outputPreview.src = this.elements.uploadPreview.src;
            } else {
                this.elements.outputPreview.src = this.activeMedium.dataset.preview;
            }

            this.elements.outputPreview.parentNode.classList.add("has-preview");
        }

        this.elements.outputElement.value = this.activeMedium.value;
        this.functions.hide();
    };

    // Finds the submit button
    this.functions.setupSubmitButton = () => {
        this.elements.submitButton = this.element.querySelector(
            "#media-picker-submit"
        );
    };

    // Finds the closing buttons
    this.functions.setupCloseButtons = () => {
        this.elements.closeButtons = this.element.querySelectorAll(
            ".media-picker-button-close"
        );
        this.elements.closeButtons.forEach(closeButton => {
            closeButton.addEventListener("click", this.functions.hide);
        });
    };

    // Finds the delete button
    this.functions.setupDeleteButton = () => {
        this.elements.deleteButton = this.element.querySelector(
            ".media-picker-button-delete"
        );

        if (this.elements.deleteButton == null) {
            console.error("Couldn't find the media picker's delete button");
            return;
        }

        this.elements.deleteButton.addEventListener(
            "click",
            this.functions.deleteImage
        );
    };

    // Finds the upload button and related elements
    this.functions.setupUploadButton = () => {
        this.elements.uploadInput = this.element.querySelector(
            "#media-picker-upload-input"
        );
        this.elements.uploadButton = this.element.querySelector(
            "#media-picker-upload-trigger"
        );

        this.elements.uploadPreview = this.element.querySelector(
            "#media-picker-upload-preview img"
        );
        this.elements.uploadPreviewRadio = this.element.querySelector(
            "#media-picker-medium-preview-radio"
        );

        this.elements.uploadButton.addEventListener("click", () => {
            this.elements.uploadInput.click();
        });

        const handleImageUploadFunction = this.functions.handleImageUpload;
        this.elements.uploadInput.addEventListener("change", function() {
            handleImageUploadFunction(this);
        });
    };

    // Sets the output element (the input outside of the media picker which we will submit a value to)
    this.functions.setOutputElement = outputElement => {
        this.elements.outputElement = outputElement;
    };

    // Sets the preview element (the preview outside of the media picker)
    this.functions.setOutputPreview = outputPreview => {
        this.elements.outputPreview = outputPreview;
    };

    // Handles when a user uploads an image
    this.functions.handleImageUpload = input => {
        const url = input.value;
        const ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();

        if (
            input.files &&
            input.files[0] &&
            (ext == "gif" ||
                ext == "png" ||
                ext == "jpeg" ||
                ext == "jpg" ||
                ext == "svg" ||
                ext == "webp" ||
                ext == "heic" ||
                ext == "heif")
        ) {
            this.functions.uploadImage();

            const reader = new FileReader();

            reader.onload = evt => {
                this.elements.uploadPreview.parentNode.style.display = "block";
                this.elements.uploadPreview.src = evt.target.result;

                this.elements.uploadPreviewRadio.click();
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            this.elements.uploadPreview.src = "NO_PREVIEW_IMG.jpg";
        }
    };

    this.functions.enableLoadingMode = () => {
        // Disable submit and upload buttons
        this.elements.submitButton.disabled = true;
        this.elements.uploadButton.disabled = true;

        // Show load/spinner in the submit and upload buttons
        this.elements.submitButton.querySelector("span").style.display = "none";
        this.elements.uploadButton.querySelector("span").style.display = "none";
        this.elements.submitButton.querySelectorAll(".icon").forEach(icon => {
            icon.style.display = "none";
        });
        this.elements.uploadButton.querySelectorAll(".icon").forEach(icon => {
            icon.style.display = "none";
        });
        this.elements.submitButton.querySelector(".spinner").style.display =
            "block";
        this.elements.uploadButton.querySelector(".spinner").style.display =
            "block";
    };

    this.functions.disableLoadingMode = () => {
        // Re-enable submit and upload buttons
        this.elements.uploadButton.disabled = false;
        this.elements.submitButton.disabled = false;

        // Hide load/spinner in the submit and upload buttons
        this.elements.submitButton.querySelector("span").style.display = "";
        this.elements.uploadButton.querySelector("span").style.display = "";
        this.elements.submitButton.querySelector(".icon").style.display = "";
        this.elements.uploadButton.querySelector(".icon").style.display = "";
    };

    // Upload the image
    this.functions.uploadImage = () => {
        const data = new FormData(this.elements.form);
        this.functions.enableLoadingMode();

        window
            .axios({
                method: this.elements.form.getAttribute("method"),
                url: this.elements.form.getAttribute("action"),
                data: data,
                config: { headers: { "Content-Type": "multipart/form-data" } }
            })
            .then(response => {
                this.elements.uploadPreviewRadio.value = response.data.id;

                this.functions.refreshView();
            })
            .catch(response => {
                this.elements.uploadPreview.parentNode.style.display = "block";
                this.elements.uploadPreview.src = "NO_PREVIEW_IMG.jpg";
                this.elements.uploadPreview.alt = "Kunne ikke laste opp";
                this.elements.uploadPreviewRadio.value = "";

                this.functions.disableLoadingMode();

                console.error(response);
            });
    };

    this.functions.deleteImage = () => {
        const data = new FormData(this.elements.form);
        const selectedImage = data.get("selected_medium");

        if (selectedImage === null) {
            alert("Velg et bilde");
            return;
        }

        this.functions.enableLoadingMode();

        window
            .axios({
                method: "delete",
                url: this.elements.form.dataset.action_delete.replace(
                    "MEDIUM_ID",
                    selectedImage
                ),
                data: data,
                config: { headers: { "Content-Type": "multipart/form-data" } }
            })
            .then(() => {
                const deletedImageWrapper = this.activeMedium
                    .nextElementSibling;

                if (
                    this.elements.outputPreview.src ===
                    deletedImageWrapper.querySelector("img").src
                ) {
                    // Null output if it's the same as the deleted
                    this.elements.outputPreview.src = "";
                    this.elements.outputElement.value = "";
                }

                this.activeMedium.parentNode.removeChild(deletedImageWrapper);
                this.activeMedium.parentNode.removeChild(this.activeMedium);
                this.elements.uploadPreview.parentNode.style.display = "none";

                this.elements.deleteButton.style.display = "none";
            })
            .catch(response => {
                this.elements.uploadPreview.parentNode.style.display = "block";
                this.elements.uploadPreview.src = "NO_PREVIEW_IMG.jpg";
                this.elements.uploadPreview.alt = "Kunne ikke slette bilde";
                this.elements.uploadPreviewRadio.value = "";

                console.error(response);
            })
            .then(() => {
                this.functions.disableLoadingMode();
            });
    };

    this.functions.loadViewIntoDocument();
};
