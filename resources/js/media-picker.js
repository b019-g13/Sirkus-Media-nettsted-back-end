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

window.mediaPicker = function(options) {
    // Inside different scopes using 'this' wont give you the class,
    // so we make a variable for it so that we can always reach it.
    // const _this = this;
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    this.name = "mediaPicker";
    this.visibility = "hidden";
    this.element = null;
    this.elements = {
        activeMedium: null
    };
    this.functions = {};
    this.events = {};

    this.events.ready = new CustomEvent("media-picker-ready");

    // Get the options passed to us, if there were any
    options == null ? (this.options = {}) : (this.options = options);

    // Set default values for those options that weren't set
    if (this.options.aSingleOption == null) this.options.aSingleOption = true;

    this.functions.loadViewIntoDocument = () => {
        axios
            .get("/media-picker")
            .then(response => {
                // handle success
                console.log(response);
                document.body.insertAdjacentHTML("beforeend", response.data);

                this.element = document.querySelector("#media-picker");
                // window.setupMediaPicker();
                // window.mediaPicker.show();
            })
            .catch(error => {
                // handle error
                console.log(error);
            })
            .then(() => {
                // always executed
                console.log("setup media picker - executed");

                console.log("bye bye", this.element);

                this.functions.setupUploadButton();
                this.functions.setupCloseButtons();
                this.functions.setupMediaChangeEvent();

                dispatchEvent(this.events.ready); // Everything should be ready
            });
    };

    this.functions.mediaChange = () => {
        console.log("change", this);
        this.elements.activeMedium = this;
    };

    this.functions.setupMediaChangeEvent = () => {
        this.elements.media = this.element.querySelectorAll(
            ".media-picker-medium-input"
        );
        this.elements.media.forEach(medium => {
            if (medium.checked) {
                this.elements.activeMedium = medium;
            }
            console.log(medium);
            medium.addEventListener("change", this.functions.mediaChange);
        });
        console.log(this.elements.activeMedium);
    };

    this.functions.showWithEnterOrSpace = evt => {
        if (evt.key === "Enter" || evt.key === " ") {
            this.functions.show();
        }
    };

    this.functions.show = () => {
        this.element.classList.remove("hide");
        this.element.classList.add("show");

        this.events.escapeKeyUp = window.addEventListener(
            "keyup",
            this.functions.hideWithEsc
        );

        this.visibility = "showing";
    };

    this.functions.hideWithEsc = evt => {
        if (evt.key === "Escape") {
            this.functions.hide();
        }
    };

    this.functions.hide = () => {
        this.element.classList.remove("show");
        this.element.classList.add("hide");

        window.removeEventListener("keyup", this.functions.hideWithEsc);

        this.visibility = "hidden";
    };

    this.functions.toggle = () => {
        if (this.visibility === "hidden") {
            this.functions.show();
        } else {
            this.functions.hide();
        }
    };

    this.functions.setupCloseButtons = () => {
        this.elements.closeButtons = this.element.querySelectorAll(
            ".media-picker-button-close"
        );
        this.elements.closeButtons.forEach(closeButton => {
            closeButton.addEventListener("click", this.functions.hide);
        });
    };
    this.functions.setupUploadButton = () => {
        this.elements.uploadInput = this.element.querySelector(
            "#media-picker-upload-input"
        );
        this.elements.uploadTrigger = this.element.querySelector(
            "#media-picker-upload-trigger"
        );

        this.elements.uploadTrigger.addEventListener("click", () => {
            this.elements.uploadInput.click();
        });
    };

    this.functions.uploadImage = function() {};

    this.functions.loadViewIntoDocument();
};
