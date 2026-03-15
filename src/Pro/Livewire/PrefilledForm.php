<?php

namespace LaraZeus\BoltPro\Livewire;

use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\URL;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Models\Form as ZeusForm;

/**
 * @property ZeusForm $record
 */
class PrefilledForm extends Page implements HasForms
{
    use InteractsWithForms;
    use InteractsWithRecord;

    protected static string $resource = FormResource::class;

    protected static string | BackedEnum | null $navigationIcon = 'tabler-input-spark';

    public array $fieldValues = [];

    public ?string $prefilledUrl = null;

    public static function getNavigationLabel(): string
    {
        return __('zeus-bolt::forms.actions.prefilled_link');
    }

    public function getTitle(): string | Htmlable
    {
        return __('zeus-bolt::forms.actions.prefilled_link');
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        /** @var ZeusForm $zeusForm */
        $zeusForm = $this->record;
        $fields = [];

        foreach ($zeusForm->fields as $field) {
            $htmlId = $field->options['htmlId'] ?? 'field_' . $field->id;
            $fields[] = TextInput::make('fieldValues.' . $htmlId)
                ->label($field->name)
                ->nullable();
        }

        return $form->schema($fields);
    }

    public function generateUrl(): void
    {
        $this->form->validate();

        $params = array_filter($this->fieldValues, fn ($v) => filled($v));

        $this->prefilledUrl = URL::route(
            BoltPlugin::get()->getRouteNamePrefix() . 'bolt.form.show',
            ['slug' => $this->record->slug]
        ) . '?' . http_build_query($params);

        Notification::make()
            ->title(__('zeus-bolt::forms.actions.prefilled_url_generated'))
            ->success()
            ->send();
    }

    protected function getViewData(): array
    {
        return [
            'prefilledUrl' => $this->prefilledUrl,
        ];
    }

    public function getView(): string
    {
        return 'zeus::pro.prefilled-form';
    }
}
