<div style="display:flex;align-items:center;gap:0.5rem;padding:0.25rem 0.25rem;width:100%;box-sizing:border-box;">
    @svg($field['icon'], '', ['style' => 'width:1.25rem;height:1.25rem;min-width:1.25rem;flex-shrink:0;color:rgb(var(--primary-500))'])
    <span style="flex:1;font-weight:600;font-size:0.875rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $field['title'] }}</span>
    <span class="tip" x-tooltip="{
            content: @js($field['description']),
            theme: $store.theme,
        }" style="flex-shrink:0;">
        @svg('heroicon-o-information-circle', '', ['style' => 'width:1rem;height:1rem;color:#9ca3af;display:block;'])
    </span>
</div>
