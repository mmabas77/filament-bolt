<div class="py-2 cursor-pointer !w-full flex items-start justify-start gap-2">
    @svg($field['icon'], '', ['style' => 'width:1.25rem;height:1.25rem;flex-shrink:0;color:rgb(var(--primary-500))'])
    <span class="w-full flex items-center justify-between gap-2">
        <span class="flex flex-col items-start justify-between gap-2">
            <span class="font-semibold">{{ $field['title'] }}</span>
            {{--<span class="text-sm field-desc">{{ $field['description'] }}</span>--}}
        </span>
        <span class="tip" x-tooltip="{
                content: @js($field['description']),
                theme: $store.theme,
            }">
            @svg('heroicon-o-information-circle', '', ['style' => 'width:1rem;height:1rem;flex-shrink:0;color:#9ca3af;margin:0 0.5rem'])
        </span>
    </span>
</div>
