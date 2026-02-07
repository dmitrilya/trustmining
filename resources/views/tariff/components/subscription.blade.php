<div
    class="w-full max-w-sm mx-auto shadow-lg shadow-logo-color bg-gray-900 dark:bg-zinc-900 border-2 border-indigo-500 rounded-3xl px-8 py-10 sm:px-10 sm:py-12 lg:px-14 lg:py-18 space-y-4 sm:space-y-8">
    <div class="h-9 flex items-end text-white md:text-lg"><span
            class="font-bold text-2xl sm:text-3xl lg:text-4xl">{{ ($tariff = App\Models\User\Tariff::where('name', 'Subscription')->first())->price * 30 }}</span> ₽/{{ __('month') }}</div>
    <a
        href="{{ route('tariff', ['tariff' => $tariff->id]) }}"><x-primary-button>{{ __('Buy plan') }}</x-primary-button></a>
    <div class="space-y-2 sm:space-y-3">
        <div class="flex items-center">
            <svg class="mr-4 flex-shrink-0 w-4 h-4 text-white" aria-hidden="true" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            <div class="text-sm text-gray-500">{{ __('Possibility to sort ads by price') }}</div>
        </div>
        <div class="flex items-center">
            <svg class="mr-4 flex-shrink-0 w-4 h-4 text-white" aria-hidden="true" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            <div class="text-sm text-gray-500">{{ __('Price change alerts') }}</div>
        </div>
        <div class="flex items-center">
            <svg class="mr-4 flex-shrink-0 w-4 h-4 text-white" aria-hidden="true" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            <div class="text-sm text-gray-500">{{ __('Viewing errors or deficiencies in contracts') }}</div>
        </div>
    </div>
</div>