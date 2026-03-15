<?php

namespace LaraZeus\BoltPro\Widgets;

use Filament\Widgets\ChartWidget;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\Form;

class ResponsesPerCollection extends ChartWidget
{
    public Form $record;

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '300px';

    public function getHeading(): string
    {
        return __('zeus-bolt::forms.widgets.responses_per_collection');
    }

    protected function getData(): array
    {
        $form = $this->record;

        // Get fields that have a collection data source
        $fields = BoltPlugin::getModel('Field')::query()
            ->whereHas('section', fn ($q) => $q->where('form_id', $form->id))
            ->whereNotNull('options->dataSource')
            ->get();

        $labels = [];
        $data = [];

        foreach ($fields as $field) {
            $dataSource = $field->options['dataSource'] ?? null;

            if (! $dataSource) {
                continue;
            }

            $collection = BoltPlugin::getModel('Collection')::query()->find($dataSource);

            if (! $collection) {
                continue;
            }

            $count = BoltPlugin::getModel('FieldResponse')::query()
                ->where('field_id', $field->id)
                ->whereHas('response', fn ($q) => $q->where('form_id', $form->id))
                ->count();

            $labels[] = $field->name . ' (' . $collection->name . ')';
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => __('zeus-bolt::forms.widgets.responses_per_collection'),
                    'data' => $data,
                    'backgroundColor' => array_map(
                        fn () => sprintf('#%06X', random_int(0, 0xFFFFFF)),
                        $data
                    ),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
