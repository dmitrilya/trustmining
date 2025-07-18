<div class="mt-2 sm:flex flex-wrap gap-1 lg:gap-2">
    @if ($user->passport && !$user->passport->moderation)
        <div
            class="cursor-default inline-flex items-center px-2 py-1 bg-white border border-gray-300 rounded-md text-xxs text-gray-700 uppercase shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
            {{ __('Identity confirmed') }}
        </div>
    @endif

    @if ($user->company && !$user->company->moderation)
        <div
            class="cursor-default inline-flex items-center px-2 py-1 bg-white border border-gray-300 rounded-md text-xxs text-gray-700 uppercase shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
            {{ __('Company verified') }}
        </div>
    @endif

    @if ($user->tariff_id == 3)
        <div
            class="cursor-default inline-flex items-center px-2 py-1 bg-white border border-gray-300 rounded-md text-xxs text-gray-700 uppercase shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
            {{ __('Market leader') }}
        </div>
    @endif
</div>
