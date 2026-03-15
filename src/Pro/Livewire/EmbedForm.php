<?php

namespace LaraZeus\BoltPro\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\View\View;
use LaraZeus\Bolt\Livewire\FillForms;

class EmbedForm extends FillForms implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public bool $inline = true;

    public function mount(
        mixed $slug,
        mixed $extensionSlug = null,
        mixed $extensionData = [],
        mixed $inline = true,
    ): void {
        parent::mount($slug, $extensionSlug, $extensionData, true);
    }

    public function render(): View
    {
        return view(app('boltTheme') . '.fill-forms');
    }
}
