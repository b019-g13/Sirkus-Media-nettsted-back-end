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
        axios
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

                this.functions.setupSubmitButton();
                this.functions.setupCloseButtons();
                this.functions.setupUploadButton();
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

    // Triggers when user selected a different medium
    this.functions.mediaChange = evt => {
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
    };

    this.functions.loadMedia = () => {
        console.log("loading media");
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

    // Upload the image
    this.functions.uploadImage = () => {
        // Disable submit and upload buttons
        this.elements.submitButton.disabled = true;
        this.elements.uploadButton.disabled = true;

        // Show load/spinner in the submit and upload buttons
        this.elements.submitButton.querySelector("span").style.display = "none";
        this.elements.uploadButton.querySelector("span").style.display = "none";
        this.elements.submitButton.querySelector(".icon").style.display =
            "block";
        this.elements.uploadButton.querySelector(".icon").style.display =
            "block";

        const data = new FormData(this.elements.form);

        axios({
            method: this.elements.form.getAttribute("method"),
            url: this.elements.form.getAttribute("action"),
            data: data,
            config: { headers: { "Content-Type": "multipart/form-data" } }
        })
            .then(response => {
                this.elements.uploadPreviewRadio.value = response.data.id;
            })
            .catch(response => {
                console.error(response);
                this.elements.uploadPreviewRadio.value = "";
            })
            .then(() => {
                // Re-enable submit and upload buttons
                this.elements.uploadButton.disabled = false;
                this.elements.submitButton.disabled = false;

                // Hide load/spinner in the submit and upload buttons
                this.elements.submitButton.querySelector("span").style.display =
                    "";
                this.elements.uploadButton.querySelector("span").style.display =
                    "";
                this.elements.submitButton.querySelector(
                    ".icon"
                ).style.display = "";
                this.elements.uploadButton.querySelector(
                    ".icon"
                ).style.display = "";
            });
    };

    this.functions.loadViewIntoDocument();
};
