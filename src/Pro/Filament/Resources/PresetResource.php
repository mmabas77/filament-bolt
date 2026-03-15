<?php

namespace LaraZeus\BoltPro\Filament\Resources;

use BackedEnum;
use Exception;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use LaraZeus\Bolt\Concerns\Schema\Fields;
use LaraZeus\Bolt\Filament\Resources\BoltResource;
use LaraZeus\BoltPro\Filament\Resources\PresetResource\Pages\CreatePreset;
use LaraZeus\BoltPro\Filament\Resources\PresetResource\Pages\EditPreset;
use LaraZeus\BoltPro\Filament\Resources\PresetResource\Pages\ListPresets;
use LaraZeus\BoltPro\Models\Field as FieldPreset;

class PresetResource extends BoltResource
{
    use Fields;
    protected static string | BackedEnum | null $navigationIcon = 'tabler-template';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModel(): string
    {
        return FieldPreset::class;
    }

    /**
     * @throws Exception
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->columns()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label(__('zeus-bolt::preset.name')),

                        Textarea::make('description')
                            ->nullable()
                            ->columnSpanFull()
                            ->label(__('zeus-bolt::preset.description')),
                    ]),

                Hidden::make('preset_data.options')
                    ->default([]),

                Repeater::make('preset_data.sections')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->addActionLabel(__('zeus-bolt::forms.section.options.add'))
                    ->cloneable()
                    ->collapsible()
                    ->collapsed(fn (string $operation) => $operation === 'edit')
                    ->defaultItems(1)
                    ->minItems(1)
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->columnSpanFull()
                            ->label(__('zeus-bolt::forms.section.name')),

                        Repeater::make('fields')
                            ->hiddenLabel()
                            ->defaultItems(1)
                            ->minItems(1)
                            ->collapsible()
                            ->cloneable()
                            ->addActionLabel(__('zeus-bolt::forms.fields.add'))
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->grid([
                                'default' => 1,
                                'md' => 2,
                                'xl' => 3,
                            ])
                            ->schema(static::getFieldsSchema()),

                        Hidden::make('compact')->default(0)->nullable(),
                        Hidden::make('aside')->default(0)->nullable(),
                        Hidden::make('borderless')->default(0)->nullable(),
                        Hidden::make('icon')->nullable(),
                        Hidden::make('columns')->default(1)->nullable(),
                        Hidden::make('description')->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('zeus-bolt::preset.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label(__('zeus-bolt::preset.description'))
                    ->limit(60)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('zeus-bolt::preset.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPresets::route('/'),
            'create' => CreatePreset::route('/create'),
            'edit' => EditPreset::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('zeus-bolt::preset.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('zeus-bolt::preset.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('zeus-bolt::preset.navigation_label');
    }
}
