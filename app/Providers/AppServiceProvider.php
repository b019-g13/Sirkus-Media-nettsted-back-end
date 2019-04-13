<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use \Blade;
use \DOMDocument;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // Setup @icon
        $this->bootBladeIconDirective();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function bootBladeIconDirective()
    {
        Blade::directive('icon', function ($arguments) {
            // Funky madness to accept multiple arguments into the directive
            list($path, $class) = array_pad(explode(',', trim($arguments, "() ")), 2, '');
            $path = trim($path, "' ");
            $path = public_path('icons/' . $path . '.svg');
            $class = trim($class, "' ");

            // Set a fallback icon
            if (!file_exists($path)) {
                $path = public_path('icons/icon-missing.svg');
            }

            // Create the dom document
            $svg = new DOMDocument();
            $svg->load($path);
            $svg->documentElement->setAttribute("class", trim('icon ' . $class));
            $svg->documentElement->setAttribute('aria-hidden', 'true');

            // Remove the title
            $svg_title = $svg->getElementsByTagName("title")->item(0);
            if ($svg_title != null) {
                $svg_head = $svg_title->parentNode;
                $svg_head->removeChild($svg_title);
            }

            $output = $svg->saveXML($svg->documentElement);
            $output = preg_replace('/\s+/', ' ', $output); // Remove line breaks and duplicate whitespace

            return $output;
        });
    }
}
