window.setupMediaPicker = function() {
    let mp = {
        element: document.querySelector("#media-picker"),
        visibility: "hidden",
        activeMedium: null,
        elements: {}
    };

    if (mp.element == null) {
        return false;
    }

    mp.elements.media = mp.element.querySelectorAll(
        ".media-picker-medium-input"
    );

    mp.elements.media.forEach(medium => {
        if (medium.checked) {
            mp.activeMedium = medium;
        }

        console.log(medium);
        medium.addEventListener("change", mediaChange);
    });

    console.log(mp.activeMedium);

    mp.show = function() {
        mp.element.classList.remove("hide");
        mp.element.classList.add("show");

        mp.visibility = "showing";
    };

    mp.hide = function() {
        mp.element.classList.remove("show");
        mp.element.classList.add("hide");

        mp.visibility = "hidden";
    };

    mp.toggle = function() {
        if (mp.visibility === "hidden") {
            mp.show();
        } else {
            mp.hide();
        }
    };

    mp.setup_upload_button = function() {
        mp.elements.uploadInput = mp.element.querySelector(
            "#media-picker-upload-input"
        );
        mp.elements.uploadTrigger = mp.element.querySelector(
            "#media-picker-upload-trigger"
        );

        mp.elements.uploadTrigger.addEventListener("click", function() {
            mp.elements.uploadInput.click();
        });
    };

    mp.upload_image = function() {};

    mp.setup_upload_button();

    function mediaChange() {
        console.log("change", mp);
        mp.activeMedium = this;
    }

    window.mediaPicker = mp;
};
