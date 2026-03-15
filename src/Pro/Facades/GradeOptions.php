<?php

namespace LaraZeus\BoltPro\Facades;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use LaraZeus\Accordion\Forms\Accordion;

class GradeOptions
{
    /**
     * Returns the grade options accordion to display in the field options panel.
     *
     * @param  array|null  $field  Current field state
     * @return array<int, Accordion>
     */
    public static function schema(?array $field = null): array
    {
        return [
            Accordion::make('grade-options')
                ->label(__('zeus-bolt::forms.fields.options.grade_options'))
                ->icon('tabler-award')
                ->columns()
                ->schema([
                    TextInput::make('options.grades.points')
                        ->label(__('zeus-bolt::forms.fields.marks.points'))
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->suffix(__('zeus-bolt::forms.fields.marks.suffix'))
                        ->columnSpanFull(),
                ]),
        ];
    }

    /**
     * Returns hidden fields to persist grade options when accordion is closed.
     *
     * @return array<int, Hidden>
     */
    public static function hidden(): array
    {
        return [
            Hidden::make('options.grades.points')->default(0),
        ];
    }
}
