<div class="sm:max-w-md p-2 h-full sm:px-4 sm:py-3 bg-white shadow-md overflow-hidden rounded-lg flex flex-col justify-between"
    x-data="{
        hidden: {{ $ad->hidden ? 'true' : 'false' }},
        toggle() {
            this.hidden = !this.hidden;
            toggleHidden({{ $ad->id }})
        }
    }">
    <div>
        <img class="w-full aspect-[4/3] overflow-hidden rounded-lg" src="{{ Storage::url($ad->preview) }}"
            alt="{{ $ad->asicVersion->asicModel->name }}">

        <div class="mt-2 sm:mt-4 text-sm sm:text-base text-gray-900 dark:text-white font-bold">
            {{ $ad->asicVersion->asicModel->name . ' ' . $ad->asicVersion->hashrate }}</div>

        <a href="{{ route('company', ['user' => $ad->user->url_name]) }}"
            class="block hover:underline text-xs sm:text-sm text-indigo-600 hover:text-indigo-500 mt-2">{{ $ad->user->name }}</a>

        <p class="mt-2 sm:mt-3 text-xxs sm:text-sm text-gray-400">{{ __('Condition') . ': ' }}<span
                class="text-gray-600">{{ $ad->new ? __('New') : __('Used') }}</span></p>

        <p class="text-xxs sm:text-sm text-gray-400">{{ __('Availability') . ': ' }}<span
                class="text-gray-600">{{ $ad->in_stock ? __('In stock') : __('Preorder') }}</span></p>

        @if (!$ad->new)
            <p class="text-xxs sm:text-sm text-gray-400">{{ __('Warranty (months)') . ': ' }}<span
                    class="text-gray-600">{{ $ad->warranty }}</span></p>
        @endif

        @if (!$ad->in_stock)
            <p class="text-xxs sm:text-sm text-gray-400">{{ __('Waiting (days)') . ': ' }}<span
                    class="text-gray-600">{{ $ad->waiting }}</span></p>
        @endif
    </div>

    <div class="mt-2">
        @if ($auth && $auth->id == $ad->user->id)
            <div class="mt-2 sm:flex">
                <div x-show="hidden"
                    class="mr-1 cursor-default inline-flex items-center px-2 py-1 bg-red-500 border border-red-500 rounded-md text-xxs text-white uppercase shadow-sm hover:bg-red-400 transition ease-in-out duration-150">
                    {{ __('Hidden') }}
                </div>

                @if ($ad->moderation)
                    <div
                        class="cursor-default inline-flex items-center px-2 py-1 bg-red-500 border border-red-500 rounded-md text-xxs text-white uppercase shadow-sm hover:bg-red-400 transition ease-in-out duration-150">
                        {{ __('Is under moderation') }}
                    </div>
                @endif
            </div>
        @endif

        <div class="sm:mt-2 text-gray-900 dark:text-white text-sm sm:text-lg font-bold">{{ $ad->price }} ₽</div>

        <div class="relative flex mt-2 sm:mt-4 items-center">
            <a class="block w-full" href="{{ route('ads.show', ['ad' => $ad->id]) }}">
                <x-primary-button class="w-full justify-center">{{ __('Details') }}</x-primary-button>
            </a>

            @if ($auth && $auth->id == $ad->user->id)
                @include('ad.components.options')
            @endif
        </div>
    </div>
</div>
