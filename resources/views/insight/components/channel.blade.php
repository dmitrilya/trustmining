@if (isset($clickable))
    <a href="{{ route('insight.channel.show', ['channel' => $slug]) }}" class="hover:opacity-80">
@endif
<div itemprop="author" itemscope itemtype="https://schema.org/Organization"
    class="mb-2 sm:mb-4{{ isset($sm) ? '' : ' lg:mb-6' }} flex items-center">
    <div
        class="{{ isset($sm) ? 'min-w-12 size-12 sm:min-w-14 sm:size-14' : 'min-w-16 size-16 sm:min-w-22 sm:size-22 lg:min-w-28 lg:size-28 lg:mr-4' }} mr-2 sm:mr-3 rounded-full border border-indigo-500 p-0.5">
        <img itemprop="logo" src="{{ Storage::url($logo) }}" alt="{{ $name }}" class="w-full rounded-full">
    </div>

    <div>
        <h4 itemprop="name"
            class="{{ isset($sm) ? 'mb-0.5 sm:mb-1 lg:text-sm' : 'mb-1 sm:mb-1.5 sm:text-sm lg:text-base' }} text-xs text-gray-900 dark:text-gray-100 font-bold">
            {{ $name }}</h4>
        <div itemprop="alternateName" class="text-xxs xs:text-xs{{ isset($sm) ? '' : ' lg:text-sm' }} text-gray-500 {{ !isset($clickable) ? ' hover:underline hover:text-indigo-500 cursor-pointer' : '' }}"
            @if (!isset($clickable)) @click="navigator.clipboard.writeText('{{ url('/insight/' . $slug) }}').then(() => {
                pushToastAlert('{{ __('Link successfully copied') }}', 'success');
            })" @endif>
            {{ '@' . $slug }}</div>
        <div itemprop="interactionStatistic" itemscope itemtype="https://schema.org/InteractionCounter"
            class="flex items-center">
            <svg class="{{ isset($sm) ? 'size-3 sm:size-4' : 'size-4 sm:size-5' }} text-gray-500" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                    d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
            </svg>

            <meta itemprop="interactionType" content="https://schema.org/SubscribeAction" />
            <div class="ml-1 sm:ml-2 text-xxs xs:text-xs{{ isset($sm) ? '' : ' lg:text-sm' }} text-gray-500">
                {{ __($subscribers) }}</div>
        </div>
        @if (!isset($sm))
            <p itemprop="description"
                class="mt-0.5 sm:mt-1 text-xs xs:text-sm{{ isset($sm) ? '' : ' lg:text-base' }} text-gray-700 dark:text-gray-300">
                {{ $description }}</p>
        @endif
    </div>

    <meta itemprop="url" content="{{ route('insight.channel.show', ['channel' => $slug]) }}" />
</div>
@if (isset($clickable))
    </a>
@endif
