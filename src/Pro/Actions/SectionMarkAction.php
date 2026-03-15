<?php

namespace LaraZeus\BoltPro\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

class SectionMarkAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('zeus-bolt::forms.section.options.mark'))
            ->icon('tabler-bookmark')
            ->color('info')
            ->tooltip(__('zeus-bolt::forms.section.options.mark_tooltip'))
            ->fillForm(fn (array $arguments, Repeater $component) => [
                'mark' => $component->getItemState($arguments['item'])['options']['mark'] ?? null,
            ])
            ->schema([
                Select::make('mark')
                    ->label(__('zeus-bolt::forms.section.options.mark_label'))
                    ->options([
                        'important' => __('zeus-bolt::forms.marks.important'),
                        'review' => __('zeus-bolt::forms.marks.review'),
                        'done' => __('zeus-bolt::forms.marks.done'),
                    ])
                    ->nullable()
                    ->placeholder(__('zeus-bolt::forms.marks.none')),
            ])
            ->action(function (array $data, array $arguments, Repeater $component): void {
                $state = $component->getState();
                $state[$arguments['item']]['options']['mark'] = $data['mark'];
                $component->state($state);
            });
    }
}
