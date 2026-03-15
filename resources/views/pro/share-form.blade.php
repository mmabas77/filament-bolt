<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('zeus-bolt::forms.actions.share') }}
        </x-slot>

        {{-- Direct link --}}
        <div class="space-y-4">
            <div>
                <x-filament::section>
                    <x-slot name="heading">
                        {{ __('zeus-bolt::forms.actions.direct_link') }}
                    </x-slot>

                    <div class="flex items-center gap-2">
                        <div class="flex-1 rounded-lg border border-gray-200 bg-gray-50 p-3 font-mono text-sm break-all dark:border-gray-700 dark:bg-gray-900">
                            {{ $this->formUrl }}
                        </div>
                        <x-filament::icon-button
                            icon="heroicon-o-clipboard"
                            x-on:click="window.navigator.clipboard.writeText('{{ $this->formUrl }}')"
                            :tooltip="__('zeus-bolt::forms.actions.copy')"
                        />
                    </div>

                    <div class="mt-3">
                        <a href="{{ $this->formUrl }}" target="_blank" class="text-primary-600 hover:underline text-sm">
                            {{ __('zeus-bolt::forms.actions.open_form') }}
                        </a>
                    </div>
                </x-filament::section>
            </div>

            {{-- Embed code --}}
            <div>
                <x-filament::section>
                    <x-slot name="heading">
                        {{ __('zeus-bolt::forms.actions.embed_code') }}
                    </x-slot>
                    <x-slot name="description">
                        {{ __('zeus-bolt::forms.actions.embed_code_hint') }}
                    </x-slot>

                    <div class="relative overflow-hidden rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                        <pre class="p-3 pe-10 font-mono text-sm whitespace-pre-wrap break-all overflow-x-auto"><code>{{ $this->embedCode }}</code></pre>
                        <div class="absolute top-2 end-2">
                            <x-filament::icon-button
                                icon="heroicon-o-clipboard"
                                x-on:click="window.navigator.clipboard.writeText({{ json_encode($this->embedCode) }})"
                                :tooltip="__('zeus-bolt::forms.actions.copy')"
                            />
                        </div>
                    </div>
                </x-filament::section>
            </div>
        </div>
    </x-filament::section>
</x-filament-panels::page>
