<div class="mt-4">
    <x-filament::section>
        <x-slot name="heading">
            {{ __('zeus-bolt::forms.extensions.grades.label') }}
        </x-slot>

        <div class="flex items-center gap-3">
            @svg('heroicon-o-academic-cap', 'h-8 w-8 text-primary-500')
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Total Points') }}
                </p>
                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                    {{ $totalPoints }}
                </p>
            </div>
        </div>
    </x-filament::section>
</div>
