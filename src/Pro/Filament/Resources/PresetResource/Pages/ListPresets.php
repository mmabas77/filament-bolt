<?php

namespace LaraZeus\BoltPro\Filament\Resources\PresetResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\BoltPro\Filament\Resources\PresetResource;

class ListPresets extends ListRecords
{
    protected static string $resource = PresetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
