<?php

namespace LaraZeus\BoltPro;

use Illuminate\Support\ServiceProvider;
use LaraZeus\BoltPro\Widgets\ResponsesCharts;
use LaraZeus\BoltPro\Widgets\ResponsesPerCollection;
use Livewire\Livewire;

class BoltProServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Livewire::component('lara-zeus.bolt-pro.widgets.responses-charts', ResponsesCharts::class);
        Livewire::component('lara-zeus.bolt-pro.widgets.responses-per-collection', ResponsesPerCollection::class);
    }
}
