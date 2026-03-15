<?php

namespace LaraZeus\BoltPro\Filament\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use LaraZeus\Bolt\Filament\Resources\BoltResource;
use LaraZeus\BoltPro\Filament\Resources\PresetResource\Pages\CreatePreset;
use LaraZeus\BoltPro\Filament\Resources\PresetResource\Pages\EditPreset;
use LaraZeus\BoltPro\Filament\Resources\PresetResource\Pages\ListPresets;
use LaraZeus\BoltPro\Models\Field as FieldPreset;

class PresetResource extends BoltResource
{
    protected static string | BackedEnum | null $navigationIcon = 'tabler-template';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModel(): string
    {
        return FieldPreset::class;
    }

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

                        Textarea::make('preset_data')
                            ->label(__('zeus-bolt::preset.preset_data'))
                            ->hint(__('zeus-bolt::preset.preset_data_hint'))
                            ->rows(15)
                            ->columnSpanFull()
                            ->afterStateHydrated(function ($state, $set) {
                                if (is_array($state)) {
                                    $set('preset_data', json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                                } elseif (empty($state)) {
                                    $set('preset_data', json_encode([
                                        'options' => (object) [],
                                        'sections' => [],
                                    ], JSON_PRETTY_PRINT));
                                }
                            })
                            ->dehydrateStateUsing(fn ($state) => json_decode((string) $state, true) ?? []),
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
