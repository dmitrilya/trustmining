<div itemprop="item" itemscope itemtype="https://schema.org/CreativeWorkSeries"
    class="relative sm:max-w-md h-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden rounded-xl flex flex-col justify-between">
    <div>
        <div class="w-full aspect-[4/3] overflow-hidden rounded-xl flex justify-center items-center">
            @php
                $preview = explode('.', $series->contents->first()->preview);
                $baseName = preg_replace('/_[0-9]+$/', '', $preview[0]);
                $previewxs = $baseName . '_340' . '.' . $preview[1];
            @endphp

            <img itemprop="image" class="w-full" src="{{ Storage::url($previewxs) }}" alt="{{ $series->name }} preview" />
        </div>
        <div class="px-2 pt-2 md:px-3 md:pt-3">
            @include('insight.components.card-channel', [
                'name' => $series->channel->name,
                'logo' => $series->channel->logo,
                'slug' => $series->channel->slug,
                'subscribers' => $series->channel->active_subscribers_count,
            ])
            <h3 itemprop="name"
                class="mt-2 sm:mt-3 text-sm sm:text-base lg:text-sm xl:text-base font-bold text-slate-800 dark:text-slate-200 h-8">
                {{ $series->name }}</h3>
        </div>
    </div>
    <div class="p-2 md:p-3 mt-1 xs:mt-2">
        <div class="flex items-center justify-between">
            <p class="text-xxs sm:text-xs text-slate-500">{{ $series->contents->first()->created_at->gt(now()->subWeek()) ? $series->contents->first()->created_at->diffForHumans() : $series->contents->first()->created_at->translatedFormat('j M') }}</p>
            <meta itemprop="dateModified" content="{{ $series->contents->first()->created_at->toIso8601String() }}" />
        </div>

        <a itemprop="url" class="block ml-auto sm:w-full mt-2"
            href="{{ route('insight.channel.series.show', ['channel' => $series->channel->slug, 'series' => $series->id . '-' . mb_strtolower(str_replace(' ', '-', $series->name))]) }}">
            <x-secondary-button class="w-full justify-center">{{ __('Open') }}</x-secondary-button>
        </a>
    </div>
</div>
