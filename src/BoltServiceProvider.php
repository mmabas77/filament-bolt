<?php

namespace LaraZeus\Bolt;

use LaraZeus\Bolt\Commands\InstallCommand;
use LaraZeus\Bolt\Commands\MakeAllFieldsActive;
use LaraZeus\Bolt\Commands\PublishCommand;
use LaraZeus\Bolt\Commands\ZeusDatasourceCommand;
use LaraZeus\Bolt\Commands\ZeusFieldCommand;
use LaraZeus\Bolt\Livewire\FillForms;
use LaraZeus\Bolt\Livewire\ListEntries;
use LaraZeus\Bolt\Livewire\ListForms;
use LaraZeus\Bolt\Support\CoreServiceProvider;
use LaraZeus\BoltPro\BoltProServiceProvider;
use LaraZeus\BoltPro\Livewire\EmbedForm;
use LaraZeus\BoltPro\Widgets\ResponsesCharts;
use LaraZeus\BoltPro\Widgets\ResponsesPerCollection;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BoltServiceProvider extends PackageServiceProvider
{
    public static string $name = 'zeus-bolt';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews('zeus')
            ->hasMigrations($this->getMigrations())
            ->hasTranslations()
            ->hasConfigFile()
            ->hasCommands($this->getCommands())
            ->hasRoute('web');
    }

    public function packageBooted(): void
    {
        CoreServiceProvider::setThemePath('bolt');

        Livewire::component('bolt.fill-form', FillForms::class);
        Livewire::component('bolt.list-forms', ListForms::class);
        Livewire::component('bolt.list-entries', ListEntries::class);

        if (class_exists(BoltProServiceProvider::class)) {
            Livewire::component('bolt.embed-form', EmbedForm::class);
            Livewire::component('lara-zeus.bolt-pro.widgets.responses-charts', ResponsesCharts::class);
            Livewire::component('lara-zeus.bolt-pro.widgets.responses-per-collection', ResponsesPerCollection::class);
        }

        $this->bootTenancySupport();
    }

    /**
     * Auto-register bolt tenant migrations with stancl/tenancy when tenant_aware is enabled.
     *
     * This allows `php artisan tenants:migrate` to create all bolt tables in every
     * tenant database without requiring any changes in the host application.
     * Set BOLT_TENANT_AWARE=true (or `tenant_aware => true` in zeus-bolt.php).
     */
    protected function bootTenancySupport(): void
    {
        if (! config('zeus-bolt.tenant_aware', false)) {
            return;
        }

        if (! class_exists(\Stancl\Tenancy\Tenancy::class)) {
            return;
        }

        $tenantMigrationsPath = __DIR__ . '/../database/migrations/tenant';

        // Publish bolt tenant migrations under a dedicated tag
        $this->publishes(
            [$tenantMigrationsPath => database_path('migrations/tenant')],
            'zeus-bolt-tenant-migrations'
        );

        // Auto-register bolt's migration path so tenants:migrate picks it up
        // without requiring the host app to publish migrations first.
        $currentPaths = config('tenancy.migration_parameters.--path');

        if ($currentPaths === null) {
            $currentPaths = [database_path('migrations/tenant')];
        } elseif (is_string($currentPaths)) {
            $currentPaths = [$currentPaths];
        }

        if (! in_array($tenantMigrationsPath, (array) $currentPaths)) {
            config(['tenancy.migration_parameters.--path' => array_merge(
                (array) $currentPaths,
                [$tenantMigrationsPath]
            )]);
        }
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            PublishCommand::class,
            ZeusFieldCommand::class,
            ZeusDatasourceCommand::class,
            InstallCommand::class,
            MakeAllFieldsActive::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_categories_table',
            'create_collections_table',
            'create_forms_table',
            'create_sections_table',
            'create_fields_table',
            'create_responses_table',
            'create_field_responses_table',
            'alter_tables_constraints',
        ];
    }
}
