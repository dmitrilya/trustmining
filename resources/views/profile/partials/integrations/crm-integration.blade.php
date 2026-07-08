<x-profile.section h="CRM integrations" :p="(!$user->company || $user->company->moderation) && !$user->passport
    ? 'Please verify your identity using your passport or register a company to create CRM integrations'
    : null">
    <div class="space-y-2 lg:space-y-4">
        @foreach (App\Models\CRM\CRMSystem::all() as $crmSystem)
            <div class="flex justify-between items-center border dark:border-slate-700 rounded-lg p-4 lg:p-6">
                <img src="{{ Storage::url('crm_systems/' . $crmSystem->name . '.webp') }}" alt="{{ $crmSystem->name }}"
                    class="w-[40%] max-w-32" />

                @if ($user->crmConnections()->where('crm_system_id', $crmSystem->id)->exists())
                    <x-buttons.secondary-button>{{ __('Connected') }}</x-buttons.secondary-button>
                @else
                    @switch($crmSystem->name)
                        @case('AmoCRM')
                            <a
                                href="https://www.amocrm.ru/oauth?client_id={{ config('services.amocrm.app.id') }}&state={{ csrf_token() }}&mode=popup">
                                <x-buttons.primary-button>{{ __('Connect') }}</x-buttons.primary-button>
                            </a>
                        @break

                        @case('Bitrix24')
                            <a href="">
                                <x-buttons.primary-button>{{ __('Connect') }}</x-buttons.primary-button>
                            </a>
                        @break
                    @endswitch
                @endif
            </div>
        @endforeach
    </div>
</x-profile.section>
