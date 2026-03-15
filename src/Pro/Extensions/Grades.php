<?php

namespace LaraZeus\BoltPro\Extensions;

use LaraZeus\Bolt\Contracts\Extension;
use LaraZeus\Bolt\Models\Form;

class Grades implements Extension
{
    public function label(): string
    {
        return __('zeus-bolt::forms.extensions.grades.label');
    }

    public function route(): string
    {
        return '#';
    }

    public function canView(Form $form, array $data): bool | array | null
    {
        return true;
    }

    public function render(Form $form, array $data): ?string
    {
        return null;
    }

    public function formComponents(Form $form): ?array
    {
        return null;
    }

    public function preStore(Form $form, array $data): bool
    {
        return true;
    }

    public function store(Form $form, array $data): ?array
    {
        return null;
    }

    public function postStore(Form $form, array $data): void {}

    public function SubmittedRender(Form $form, array $data): ?string
    {
        // Calculate and display total grade points for the submission
        $response = $data['response'] ?? null;

        if (! $response) {
            return null;
        }

        $totalPoints = 0;

        foreach ($response->fieldsResponses as $fieldResponse) {
            $field = $fieldResponse->field;
            $points = (int) ($field->options['grades']['points'] ?? 0);
            $totalPoints += $points;
        }

        return view('zeus::pro.grades-result', ['totalPoints' => $totalPoints])->render();
    }

    public function getItems(Form $form): array
    {
        return [];
    }

    public function getUrl(Form $form, array $extension): string
    {
        return '#';
    }

    public function canDelete(Form $form, array $extension): bool
    {
        return true;
    }

    public function canDeleteResponse(Form $form, array $extension): bool
    {
        return true;
    }
}
