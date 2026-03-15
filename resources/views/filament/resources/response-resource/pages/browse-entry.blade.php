<div x-data class="space-y-4 my-6 mx-4 w-full">
    @php
        $getRecord = $getRecord();
        $userModel = config('auth.providers.users.model');
        $nameAttr = method_exists($userModel, 'getBoltUserFullNameAttribute')
            ? $userModel::getBoltUserFullNameAttribute()
            : 'name';
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
            <x-filament::section>
                <x-slot name="heading">
                    {{ __('zeus-bolt::response.field_responses') }}
                </x-slot>
                @foreach($getRecord->fieldsResponses as $resp)
                    @if($resp->field !== null)
                        <div class="py-3 text-ellipsis overflow-auto">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ $resp->field->name ?? '' }}
                            </span>

                            <div class="items-center flex justify-between mt-1">
                                <p class="font-semibold text-gray-950 dark:text-white">
                                    {!! ( new $resp->field->type )->getResponse($resp->field, $resp) !!}
                                </p>
                                @if($resp->form->extensions === 'LaraZeus\\BoltPro\\Extensions\\Grades')
                                    <livewire:bolt-pro.grading :response="$resp" />
                                @endif
                            </div>

                            <hr class="mt-3 border-gray-200 dark:border-gray-700"/>
                        </div>
                    @endif
                @endforeach
            </x-filament::section>
        </div>
        <div class="space-y-4">
            <x-filament::section>
                <x-slot name="heading">
                    {{ __('zeus-bolt::response.user_details') }}
                </x-slot>
                @if($getRecord->user_id === null)
                    <span>{{ __('zeus-bolt::response.by_visitor') }}</span>
                @else
                    <div class="flex gap-2 items-center">
                        <x-filament::avatar
                                class="rounded-full"
                                size="lg"
                                :src="$getRecord->user->avatar ?? ''"
                                :alt="($getRecord->user->{$nameAttr}) ?? ''"
                        />
                        <p class="flex flex-col gap-1">
                            <span>{{ ($getRecord->user->{$nameAttr}) ?? '' }}</span>
                            <span>{{ ($getRecord->user->email) ?? '' }}</span>
                        </p>
                    </div>
                @endif
                <p class="flex flex-col my-1 gap-1">
                    <span class="text-base font-light">{{ __('zeus-bolt::response.created_at') }}:</span>
                    <span class="font-semibold">{{ $getRecord->created_at->format('M d, Y H:i') }}</span>
                </p>
            </x-filament::section>
            <x-filament::section>
                <x-slot name="heading">
                    {{ __('zeus-bolt::response.entry_details') }}
                </x-slot>

                <div class="flex flex-col mb-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('zeus-bolt::response.form') }}:</span>
                    <span class="font-medium">{{ $getRecord->form->name ?? '' }}</span>
                </div>

                <div class="mb-4 flex items-center gap-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('zeus-bolt::response.status') }}:</span>
                    <x-filament::badge :color="$getRecord->status->getColor()">
                        {{ $getRecord->status->getLabel() }}
                    </x-filament::badge>
                </div>

                <div class="flex flex-col">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('zeus-bolt::response.notes') }}:</span>
                    {!! nl2br(e($getRecord->notes)) !!}
                </div>
            </x-filament::section>
        </div>
    </div>
</div>
