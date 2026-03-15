<?php

namespace LaraZeus\Bolt\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class ListForms extends Component
{
    public function render(): View
    {
        if (function_exists('seo')) {
            try {
                $seo = seo()
                    ->site(config('zeus.site_title', 'Laravel'))
                    ->title(__('zeus-bolt::forms.forms') . ' - ' . config('zeus.site_title'))
                    ->description(__('zeus-bolt::forms.forms') . ' - ' . config('zeus.site_description') . ' ' . config('zeus.site_title'))
                    ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
                    ->rawTag('<meta name="theme-color" content="' . config('zeus.site_color') . '" />');

                if (method_exists($seo, 'withUrl')) {
                    $seo = $seo->withUrl();
                }
                if (method_exists($seo, 'twitter')) {
                    $seo->twitter();
                }
            } catch (\Throwable) {
                // SEO helpers are optional — fail silently
            }
        }

        $layout = config('zeus.layout', config('livewire.layout', 'components.layouts.app'));

        $categories = config('zeus-bolt.models.Category')::query()
            ->whereHas('forms', function ($query) {
                $query->whereNull('extensions');
            })
            ->where('is_active', 1)
            ->orderBy('ordering')
            ->get();

        // Forms that have no category assigned
        $uncategorizedForms = config('zeus-bolt.models.Form')::query()
            ->whereNull('category_id')
            ->whereNull('extensions')
            ->where('is_active', 1)
            ->orderBy('ordering')
            ->get();

        return view(app('boltTheme') . '.list-forms')
            ->with('categories', $categories)
            ->with('uncategorizedForms', $uncategorizedForms)
            ->layout($layout);
    }
}
