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

    <div class="space-y-3 sm:space-y-4 lg:space-y-5">
        @foreach (App\Models\CRMSystem::all() as $crmSystem)
            <div class="flex justify-between">
                <img src="{{ Storage::url('crm_systems/' . $crmSystem->name . '.webp') }}" alt="{{ $crmSystem->name }}" class="w-1/3" />
            </div>
        @endforeach
    </div>
</section>
