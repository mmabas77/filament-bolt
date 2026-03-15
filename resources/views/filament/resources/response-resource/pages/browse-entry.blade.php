<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:start;margin:1.5rem 0;width:100%;flex:1;">
    @php
        $getRecord = $getRecord();
    @endphp

    {{-- Main: Form field responses --}}
    <div>
        <x-filament::section>
            @foreach($getRecord->fieldsResponses as $resp)
                @if($resp->field !== null)
                    <div style="padding:0.5rem 0;border-bottom:1px solid #f3f4f6;">
                        <p style="font-size:0.75rem;color:#6b7280;text-transform:uppercase;margin-bottom:0.25rem;">
                            {{ $resp->field->name ?? '' }}
                        </p>
                        <div>
                            {!! ( new $resp->field->type )->getResponse($resp->field, $resp) !!}
                        </div>
                        @if($resp->form->extensions === 'LaraZeus\\BoltPro\\Extensions\\Grades')
                            <livewire:bolt-pro.grading :response="$resp" />
                        @endif
                    </div>
                @endif
            @endforeach
        </x-filament::section>
    </div>

    {{-- Sidebar --}}
    <div style="display:flex;flex-direction:column;gap:1rem;">

        {{-- User Details --}}
        <x-filament::section>
            <x-slot name="heading">{{ __('zeus-bolt::response.user_details') }}</x-slot>
            @if($getRecord->user_id === null)
                <p style="font-size:0.875rem;color:#6b7280;">{{ __('zeus-bolt::response.by_visitor') }}</p>
            @else
                @php
                    $userModel = config('auth.providers.users.model');
                    $nameAttr = method_exists($userModel, 'getBoltUserFullNameAttribute')
                        ? $userModel::getBoltUserFullNameAttribute()
                        : 'name';
                @endphp
                <div style="display:flex;gap:0.75rem;align-items:center;">
                    <x-filament::avatar
                        size="lg"
                        :src="$getRecord->user->avatar ?? ''"
                        :alt="($getRecord->user->{$nameAttr}) ?? ''"
                    />
                    <div>
                        <p style="font-weight:500;font-size:0.875rem;">{{ ($getRecord->user->{$nameAttr}) ?? '' }}</p>
                        <p style="font-size:0.75rem;color:#6b7280;">{{ ($getRecord->user->email) ?? '' }}</p>
                    </div>
                </div>
            @endif
            <div style="margin-top:0.75rem;padding-top:0.75rem;border-top:1px solid #f3f4f6;font-size:0.875rem;">
                <span style="color:#6b7280;">{{ __('zeus-bolt::response.created_at') }}:</span>
                <span style="font-weight:500;">{{ $getRecord->created_at->format('Y-m-d H:i') }}</span>
            </div>
        </x-filament::section>

        {{-- Entry Details --}}
        <x-filament::section>
            <x-slot name="heading">{{ __('zeus-bolt::response.entry_details') }}</x-slot>
            <div style="display:flex;flex-direction:column;gap:0.75rem;font-size:0.875rem;">
                <div>
                    <p style="font-size:0.75rem;color:#6b7280;text-transform:uppercase;">{{ __('zeus-bolt::response.form') }}</p>
                    <p style="font-weight:500;">{{ $getRecord->form->name ?? '' }}</p>
                </div>
                <div>
                    <p style="font-size:0.75rem;color:#6b7280;text-transform:uppercase;margin-bottom:0.25rem;">{{ __('zeus-bolt::response.status') }}</p>
                    <x-filament::badge :color="$getRecord->status->getColor()">
                        {{ $getRecord->status->getLabel() }}
                    </x-filament::badge>
                </div>
                @if($getRecord->notes)
                    <div>
                        <p style="font-size:0.75rem;color:#6b7280;text-transform:uppercase;">{{ __('zeus-bolt::response.notes') }}</p>
                        <p>{!! nl2br(e($getRecord->notes)) !!}</p>
                    </div>
                @endif
            </div>
        </x-filament::section>

    </div>
</div>
