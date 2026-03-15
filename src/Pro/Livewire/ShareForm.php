<?php

namespace LaraZeus\BoltPro\Livewire;

use BackedEnum;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Models\Form as ZeusForm;

/**
 * @property ZeusForm $record
 */
class ShareForm extends Page
{
    protected static string $resource = FormResource::class;

    protected static string | BackedEnum | null $navigationIcon = 'tabler-share';

    public ?string $formUrl = null;

    public ?string $embedCode = null;

    public static function getNavigationLabel(): string
    {
        return __('zeus-bolt::forms.actions.share');
    }

    public function getTitle(): string | Htmlable
    {
        return __('zeus-bolt::forms.actions.share');
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        /** @var ZeusForm $zeusForm */
        $zeusForm = $this->record;

        $this->formUrl = route(
            BoltPlugin::get()->getRouteNamePrefix() . 'bolt.form.show',
            ['slug' => $zeusForm->slug]
        );

        $embedUrl = route(
            BoltPlugin::get()->getRouteNamePrefix() . 'bolt.form.embed',
            ['slug' => $zeusForm->slug]
        );

        $this->embedCode = '<iframe src="' . $embedUrl . '" width="100%" height="600" frameborder="0" allowtransparency="true"></iframe>';
    }

    protected function getView(): string
    {
        return 'zeus::pro.share-form';
    }
}
