<div class="relative sm:max-w-md p-2 h-full md:p-3 bg-white shadow-md overflow-hidden rounded-lg flex flex-col justify-between"
    x-data="{
        hidden: {{ $ad->hidden ? 'true' : 'false' }},
        toggle() {
            toggleHidden({{ $ad->id }}).then(r => this.hidden = r ? !this.hidden : this.hidden);
        }
    }">
    <div>
        @if ($owner)
            <div class="mt-2 absolute left-0 top-4">
                <div x-show="hidden" style="display: none"
                    class="w-max cursor-default items-center px-1 py-0.5 bg-gray-800 opacity-60 border border-red-500 rounded-e-md text-xxs text-white uppercase shadow-sm hover:bg-red-400 transition ease-in-out duration-150">
                    {{ __('Hidden') }}
                </div>

                @if ($ad->moderations->where('moderation_status_id', 1)->count())
                    <div
                        class="mt-1.5 w-max cursor-default items-center px-1 py-0.5 bg-gray-800 opacity-60 border border-red-500 rounded-e-md text-xxs text-white uppercase shadow-sm hover:bg-red-400 transition ease-in-out duration-150">
                        {{ __('Is under moderation') }}
                    </div>
                @elseif (($lastM = $ad->moderations->reverse()->first()) && $lastM->moderation_status_id == 3)
                    <div
                        class="mt-1.5 w-max cursor-default items-center px-1 py-0.5 bg-red-900 opacity-60 border border-red-500 rounded-e-md text-xxs text-white uppercase shadow-sm hover:bg-red-400 transition ease-in-out duration-150">
                        {{ __('Rejected') }}
                    </div>
                @endif
            </div>
        @endif

        <div class="w-full aspect-[4/3] overflow-hidden rounded-lg overflow-hidden flex justify-center items-center">
            <img class="w-full" src="{{ Storage::url($ad->preview) }}" alt="{{ $ad->asicVersion->asicModel->name }}">
        </div>

        <div class="mt-2 md:mt-3 text-sm md:text-base text-gray-900 dark:text-white font-bold">
            {{ $ad->asicVersion->asicModel->name . ' ' . $ad->asicVersion->hashrate . $ad->asicVersion->measurement }}
        </div>

        <a href="{{ route('company', ['user' => $ad->user->url_name]) }}"
            class="block hover:underline text-xs md:text-sm text-indigo-600 hover:text-indigo-500 mt-1">{{ $ad->user->name }}</a>

        <p class="mt-1 md:mt-2 text-xxs sm:text-xs md:text-sm text-gray-400">
            {{ __('Trust Factor') }}: <span class="text-gray-600">{{ $ad->user->tf }}</span>
        </p>

        <p class="mt-1 md:mt-2 text-xxs sm:text-xs md:text-sm text-gray-400">
            {{ __('Condition') . ': ' }}<span class="text-gray-600">{{ $ad->new ? __('New') : __('Used') }}</span>
        </p>

        <p class="text-xxs sm:text-xs md:text-sm text-gray-400">
            {{ __('Availability') . ': ' }}<span
                class="text-gray-600">{{ $ad->in_stock ? __('In stock') : __('Preorder') }}</span>
        </p>

        @if (!$ad->new)
            <p class="text-xxs sm:text-xs md:text-sm text-gray-400">
                {{ __('Warranty (months)') . ': ' }}<span class="text-gray-600">{{ $ad->warranty }}</span>
            </p>
        @endif

        @if (!$ad->in_stock)
            <p class="text-xxs sm:text-xs md:text-sm text-gray-400">
                {{ __('Waiting (days)') . ': ' }}<span class="text-gray-600">{{ $ad->waiting }}</span>
            </p>
        @endif
    </div>

    <div class="mt-2 md:mt-3">
        <div class="text-gray-900 dark:text-white text-sm sm:text-base font-bold">{{ $ad->price }} ₽</div>

        <a href="{{ route('company.office', ['user' => $ad->user->url_name, 'office' => $ad->office->id]) }}"
            target="_blank"
            class="block hover:underline text-xxs sm:text-xs text-indigo-600 hover:text-indigo-500 mt-1">{{ $ad->office->city }}</a>

        <div class="relative flex mt-2 items-center">
            <a class="block w-full" href="{{ route('ads.show', ['ad' => $ad->id]) }}">
                <x-primary-button
                    class="w-full justify-center text-xxs xs:text-xs">{{ __('Details') }}</x-primary-button>
            </a>

            @include('ad.components.options', ['owner' => $owner])
        </div>
    </div>
</div>
