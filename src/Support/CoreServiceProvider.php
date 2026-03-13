<?php

namespace LaraZeus\Bolt\Support;

use Illuminate\Support\Facades\View;

/**
 * Stub replacing lara-zeus/core's CoreServiceProvider::setThemePath().
 * We inlined this single method to avoid the lara-zeus/core dependency, which
 * pulls in lara-zeus/laravel-seo → intervention/image ^2.7, conflicting with
 * TW-Blog's intervention/image ^3.0.
 */
class CoreServiceProvider
{
    public static function setThemePath(string $path): void
    {
        $viewPath = 'zeus::themes.' . config('zeus.theme') . '.' . $path;
        $folder = resource_path('views/vendor/zeus/themes/' . config('zeus.theme') . '/' . $path);

        if (! is_dir($folder)) {
            $folder = base_path('vendor/lara-zeus/artemis/resources/views/themes/' . config('zeus.theme') . '/' . $path);
            if (! is_dir($folder)) {
                $viewPath = 'zeus::themes.zeus.' . $path;
            }
        }

        View::share($path . 'Theme', $viewPath);
        app()->instance($path . 'Theme', $viewPath);
    }
}
