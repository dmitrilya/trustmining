<section>
    <header class="mb-6">
        <h2 class="text-lg text-slate-950 dark:text-slate-50 mb-2">
            {{ __('CRM integrations') }}
        </h2>

        @if ((!$user->company || $user->company->moderation) && !$user->passport)
            <p class="text-sm text-slate-700 dark:text-slate-400">
                {{ __('Please verify your identity using your passport or register a company to create CRM integrations.') }}
            </p>
        @endif
    </header>

    <div class="space-y-4 sm:space-y-5 lg:space-y-6">
        @foreach (App\Models\CRM\CRMSystem::all() as $crmSystem)
            <div class="flex justify-between items-center border dark:border-slate-700 rounded-lg p-4 xl:p-6">
                <img src="{{ Storage::url('crm_systems/' . $crmSystem->name . '.webp') }}" alt="{{ $crmSystem->name }}"
                    class="w-[40%]" />

                @if ($user->crmConnections()->where('crm_system_id', $crmSystem->id)->exists())
                        <x-secondary-button>{{ __('Connected') }}</x-secondary-button>
                @else
                    @switch($crmSystem->name)
                        @case('AmoCRM')
                            <a href="https://www.amocrm.ru/oauth?client_id={{ config('services.amocrm.app.id') }}&state={{ csrf_token() }}&mode=popup">
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
