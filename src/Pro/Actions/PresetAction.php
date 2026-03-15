<?php

namespace LaraZeus\BoltPro\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\BoltPro\Models\Field as FieldPreset;

class PresetAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('zeus-bolt::forms.actions.new_from_preset'))
            ->icon('tabler-template')
            ->color('info')
            ->schema([
                Select::make('preset_id')
                    ->label(__('zeus-bolt::forms.actions.select_preset'))
                    ->options(fn () => FieldPreset::query()->pluck('name', 'id'))
                    ->required()
                    ->live(),
                TextInput::make('name')
                    ->label(__('zeus-bolt::forms.options.tabs.title.name'))
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label(__('zeus-bolt::forms.options.tabs.title.slug'))
                    ->required()
                    ->unique(BoltPlugin::getModel('Form'), 'slug')
                    ->rules(['alpha_dash']),
            ])
            ->action(function (array $data): void {
                $preset = FieldPreset::query()->find($data['preset_id']);

                if (! $preset) {
                    return;
                }

                $form = BoltPlugin::getModel('Form')::create([
                    'name' => $data['name'],
                    'slug' => $data['slug'],
                    'user_id' => auth()->id(),
                    'is_active' => false,
                    'options' => $preset->preset_data['options'] ?? [],
                ]);

                foreach ($preset->preset_data['sections'] ?? [] as $sectionData) {
                    $section = BoltPlugin::getModel('Section')::create(array_merge(
                        $sectionData,
                        ['form_id' => $form->id, 'id' => null]
                    ));

                    foreach ($sectionData['fields'] ?? [] as $fieldData) {
                        BoltPlugin::getModel('Field')::create(array_merge(
                            $fieldData,
                            ['section_id' => $section->id, 'id' => null]
                        ));
                    }
                }

                Notification::make()
                    ->title(__('zeus-bolt::forms.actions.preset_created'))
                    ->success()
                    ->send();
            });
    }
}
