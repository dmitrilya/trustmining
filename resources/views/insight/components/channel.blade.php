@if (isset($clickable))
    <a href="{{ route('insight.channel.show', ['channel' => $slug]) }}" class="hover:opacity-80">
@endif
<div class="mb-2 sm:mb-4{{ isset($sm) ? '' : ' lg:mb-6' }} flex items-center">
    <div
        class="{{ isset($sm) ? 'min-w-12 w-12 h-12 sm:min-w-14 sm:w-14 sm:h-14' : 'min-w-16 w-16 h-16 sm:min-w-20 sm:w-20 sm:h-20 lg:min-w-28 lg:w-28 lg:h-28 lg:mr-4' }} mr-2 sm:mr-3 rounded-full border border-indigo-500 p-0.5">
        <img itemprop="logo" src="{{ Storage::url($logo) }}" alt="{{ $name }}" class="w-full rounded-full">
    </div>

    <div>
        <p itemprop="name"
            class="{{ isset($sm) ? 'mb-0.5 sm:mb-1 lg:text-sm' : 'mb-1 sm:mb-1.5 sm:text-sm lg:text-base' }} text-xs text-slate-900 dark:text-slate-100 font-bold">
            {{ $name }}</p>
        <div itemprop="alternateName"
            class="text-xxs xs:text-xs{{ isset($sm) ? '' : ' lg:text-sm' }} text-slate-500 {{ !isset($clickable) ? ' hover:underline hover:text-indigo-600 cursor-pointer' : '' }}"
            @if (!isset($clickable)) @click="navigator.clipboard.writeText('{{ url('/insight/' . $slug) }}').then(() => {
                pushToastAlert('{{ __('Link successfully copied') }}', 'success');
            })" @endif>
            {{ '@' . $slug }}</div>
        <div itemprop="interactionStatistic" itemscope itemtype="https://schema.org/InteractionCounter"
            class="flex items-center">
            <svg class="{{ isset($sm) ? 'w-3 h-3 sm:w-4 sm:h-4' : 'w-4 h-4 sm:w-5 sm:h-5' }} text-slate-500" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                    d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
            </svg>

            <meta itemprop="interactionType" content="https://schema.org/SubscribeAction" />
            <div itemprop="userInteractionCount"
                class="ml-1 sm:ml-2 text-xxs xs:text-xs{{ isset($sm) ? '' : ' lg:text-sm' }} text-slate-500">
                {{ $subscribers }}</div>
        </div>
        @if (!isset($sm))
            <p
                class="mt-0.5 sm:mt-1 text-xs xs:text-sm{{ isset($sm) ? '' : ' lg:text-base' }} text-slate-700 dark:text-slate-300">
                {{ $description }}</p>
        @endif
    </div>

    <link itemprop="url" href="{{ route('insight.channel.show', ['channel' => $slug]) }}" />
</div>
@if (isset($clickable))
    </a>
@endif
