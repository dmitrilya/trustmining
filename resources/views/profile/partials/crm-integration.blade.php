<section>
    <header class="mb-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
            {{ __('CRM integrations') }}
        </h2>

        @if ((!$user->company || $user->company->moderation) && !$user->passport)
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Please verify your identity using your passport or register a company to create CRM integrations.') }}
            </p>
        @endif
    </header>

    <div class="space-y-4 sm:space-y-5 lg:space-y-6">
        @foreach (App\Models\CRMSystem::all() as $crmSystem)
            <div class="flex justify-between items-center border dark:border-zinc-700 rounded-lg p-4 xl:p-6">
                <img src="{{ Storage::url('crm_systems/' . $crmSystem->name . '.webp') }}" alt="{{ $crmSystem->name }}"
                    class="w-[40%]" />

                @if ($user->crmConnections()->where('crm_system_id', $crmSystem->id)->exists())
                        <x-secondary-button>{{ __('Connected') }}</x-secondary-button>
                @else
                    @switch($crmSystem->name)
                        @case('AmoCRM')
                            <a href="https://www.amocrm.ru/oauth?client_id={{ config('services.amocrm.integration.id') }}&state={{ csrf_token() }}&mode=popup">
                                <x-primary-button>{{ __('Connect') }}</x-primary-button>
                            </a>
                        @break

                        @case('Bitrix24')
                            <a href="">
                                <x-primary-button>{{ __('Connect') }}</x-primary-button>
                            </a>
                        @break
                    @endswitch
                @endif
            </div>
        @endforeach
    </div>
</section>
