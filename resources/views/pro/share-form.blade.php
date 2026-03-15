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

                    <div style="display: flex; align-items: center; gap: 0.5rem; border-radius: 0.5rem; border: 1px solid rgb(229 231 235); background-color: rgb(249 250 251); padding: 0.5rem; padding-inline-start: 0.75rem;">
                        <div style="flex: 1; min-width: 0; font-family: ui-monospace, monospace; font-size: 0.875rem; word-break: break-all; overflow-wrap: break-word;">
                            {{ $this->formUrl }}
                        </div>
                        <x-filament::icon-button
                            icon="heroicon-o-clipboard"
                            x-on:click="window.navigator.clipboard.writeText('{{ $this->formUrl }}')"
                            :tooltip="__('zeus-bolt::forms.actions.copy')"
                        />
                        <x-filament::button
                            :href="$this->formUrl"
                            tag="a"
                            target="_blank"
                            icon="heroicon-o-arrow-top-right-on-square"
                            size="sm"
                            outlined
                        >
                            {{ __('zeus-bolt::forms.actions.open_form') }}
                        </x-filament::button>
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

                    <div style="position: relative; overflow: hidden; border-radius: 0.5rem; border: 1px solid rgb(229 231 235); background-color: rgb(249 250 251);">
                        <pre style="white-space: pre-wrap; word-break: break-all; overflow-wrap: break-word; padding: 0.75rem; padding-inline-end: 2.5rem; margin: 0; font-family: ui-monospace, monospace; font-size: 0.875rem;"><code>{{ $this->embedCode }}</code></pre>
                        <div style="position: absolute; top: 0.5rem; inset-inline-end: 0.5rem;">
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
