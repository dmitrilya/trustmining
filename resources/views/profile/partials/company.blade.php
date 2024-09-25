<section class="space-y-6">
    <header>
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Company') }}
            </h2>

            @if (!$user->company)
                <a href="{{ route('company.create') }}"><x-primary-button>{{ __('Create') }}</x-primary-button></a>
            @elseif (!$user->company->moderation)
                <a href="{{ route('company.edit', ['company' => $user->company->id]) }}">
                    <x-primary-button>{{ __('Edit') }}</x-primary-button>
                </a>
            @endif
        </div>
    </header>

    <div class="mt-6">
        @if (!$user->company)
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Add information about your company.') }}
            </p>
        @elseif ($user->company->moderation)
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Is under moderation') }}
            </p>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('The company is registered. Now you can fill the About page with an additional description that reveals your values ​​and a photo.') }}
            </p>
        @endif
    </div>
</section>
