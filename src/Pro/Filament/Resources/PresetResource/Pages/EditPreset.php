<?php

namespace LaraZeus\BoltPro\Filament\Resources\PresetResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\BoltPro\Filament\Resources\PresetResource;

class EditPreset extends EditRecord
{
    protected static string $resource = PresetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
