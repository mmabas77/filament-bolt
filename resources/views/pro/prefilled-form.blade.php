<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('zeus-bolt::forms.actions.prefilled_link') }}
        </x-slot>
        <x-slot name="description">
            {{ __('Fill in default values for each field, then generate a pre-filled link to share.') }}
        </x-slot>

        <form wire:submit="generateUrl">
            {{ $this->form }}

            <div class="mt-6">
                <x-filament::button type="submit">
                    {{ __('zeus-bolt::forms.actions.generate_url') }}
                </x-filament::button>
            </div>
        </form>

        @if($prefilledUrl)
            <div class="mt-6">
                <x-filament::section>
                    <x-slot name="heading">
                        {{ __('zeus-bolt::forms.actions.prefilled_url_generated') }}
                    </x-slot>

                    <div class="flex items-center gap-2">
                        <div class="flex-1 rounded-lg border border-gray-200 bg-gray-50 p-3 font-mono text-sm break-all dark:border-gray-700 dark:bg-gray-900">
                            {{ $prefilledUrl }}
                        </div>
                        <x-filament::icon-button
                            icon="heroicon-o-clipboard"
                            wire:click="$dispatch('copy-to-clipboard', { text: '{{ $prefilledUrl }}' })"
                            :tooltip="__('Copy')"
                        />
                    </div>

                    <div class="mt-3">
                        <a href="{{ $prefilledUrl }}" target="_blank" class="text-primary-600 hover:underline text-sm">
                            {{ __('Open link') }}
                        </a>
                    </div>
                </x-filament::section>
            </div>
        @endif
    </x-filament::section>
</x-filament-panels::page>
