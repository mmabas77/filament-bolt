<?php

namespace LaraZeus\Bolt;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\BoltPro\BoltProServiceProvider;
use LaraZeus\BoltPro\Filament\Resources\PresetResource;
use LaraZeus\FilamentPluginTools\Concerns\CanDisableBadges;
use LaraZeus\FilamentPluginTools\Concerns\CanGloballySearch;
use LaraZeus\FilamentPluginTools\Concerns\CanHideResources;
use LaraZeus\FilamentPluginTools\Concerns\CanStickyActions;
use LaraZeus\FilamentPluginTools\Concerns\HasEnums;
use LaraZeus\FilamentPluginTools\Concerns\HasModels;
use LaraZeus\FilamentPluginTools\Concerns\HasNavigationGroupLabel;
use LaraZeus\FilamentPluginTools\Concerns\HasRouteNamePrefix;

final class BoltPlugin implements Plugin
{
    use CanDisableBadges;
    use CanGloballySearch;
    use CanHideResources;
    use CanStickyActions;
    use Configuration;
    use EvaluatesClosures;
    use HasEnums;
    use HasModels;
    use HasNavigationGroupLabel;
    use HasRouteNamePrefix;

    protected Closure | string $navigationGroupLabel = 'Forms';

    public array $defaultGloballySearchableAttributes = [
        CategoryResource::class => ['name', 'slug'],
        CollectionResource::class => ['name', 'values'],
        FormResource::class => ['name', 'slug'],
    ];

    public function getId(): string
    {
        return 'zeus-bolt';
    }

    public function register(Panel $panel): void
    {
        $resources = [
            CollectionResource::class,
            FormResource::class,
            CategoryResource::class,
        ];

        if (class_exists(BoltProServiceProvider::class)) {
            $resources[] = PresetResource::class;
        }

        $panel->resources($resources);
    }

    public static function make(): static
    {
        return new self;
    }

    public static function get(): static
    {
        // @phpstan-ignore-next-line
        return filament('zeus-bolt');
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
