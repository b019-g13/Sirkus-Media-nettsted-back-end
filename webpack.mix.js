const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js").version();
mix.js("resources/js/page.js", "public/js").version();
mix.js("resources/js/component.js", "public/js").version();
mix.js("resources/js/media-picker.js", "public/js").version();
mix.sass("resources/sass/app.scss", "public/css").version();
mix.copy("resources/images", "public/images").version();

mix.browserSync({
    proxy: "localhost:8000",
    notify: false
});

mix.disableSuccessNotifications();
