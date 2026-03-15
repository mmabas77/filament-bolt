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

                    <div class="flex items-start gap-2">
                        <pre class="flex-1 rounded-lg border border-gray-200 bg-gray-50 p-3 font-mono text-sm break-all whitespace-pre-wrap dark:border-gray-700 dark:bg-gray-900"><code>{{ $this->embedCode }}</code></pre>
                        <x-filament::icon-button
                            icon="heroicon-o-clipboard"
                            x-on:click="window.navigator.clipboard.writeText({{ json_encode($this->embedCode) }})"
                            :tooltip="__('zeus-bolt::forms.actions.copy')"
                        />
                    </div>
                </x-filament::section>
            </div>
        </div>
    </x-filament::section>
</x-filament-panels::page>
