<?php

namespace LaraZeus\Bolt\Filament\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use Livewire\Livewire;

class ResponseExporter extends Exporter
{
    protected static ?string $model = Response::class;

    protected ?Model $record;

    public function getCachedColumns(): array
    {
        $id = $this->getOptions()['export_form_id'] ?? 0;
        $record = BoltPlugin::getModel('Form')::find($id);

        return $this->cachedColumns ??= array_reduce(static::getFormColumns($record), function (array $carry, ExportColumn $column): array {
            $carry[$column->getName()] = $column->exporter($this);

            return $carry;
        }, []);
    }

    public static function getColumns(): array
    {
        return static::getFormColumns(Livewire::current()->getRecord());
    }

    public static function getFormColumns(?Form $record = null): array
    {
        if ($record === null) {
            return [];
        }

        // todo refactor with v4
        $userModel = BoltPlugin::getModel('User') ?? config('auth.providers.users.model');
        $getUserModel = $userModel::getBoltUserFullNameAttribute();
        $mainColumns = [
            ExportColumn::make('user.' . $getUserModel)
                ->label(__('zeus-bolt::response.name'))
                ->default(__('zeus-bolt::response.guest')),

            ExportColumn::make('status')
                ->formatStateUsing(function ($state): string {
                    return $state->getLabel();
                })
                ->label(__('zeus-bolt::response.status')),

            ExportColumn::make('notes')
                ->label(__('zeus-bolt::response.notes')),
        ];

        /**
         * @var Field $field.
         */
        foreach ($record->fields->sortBy('ordering') as $field) {
            $getFieldTableColumn = (new $field->type)->ExportColumn($field);

            if ($getFieldTableColumn !== null) {
                $mainColumns[] = $getFieldTableColumn;
            }
        }

        $mainColumns[] = ExportColumn::make('created_at')
            ->label(__('zeus-bolt::response.created_at'));

        return $mainColumns;
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = __('zeus-bolt::response.export.completed', [
            'count' => number_format($export->successful_rows),
        ]);

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . __('zeus-bolt::response.export.failed', [
                'count' => number_format($failedRowsCount),
            ]);
        }

        return $body;
    }
}
