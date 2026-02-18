<div
    class="relative sm:max-w-md h-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-md shadow-logo-color overflow-hidden rounded-xl flex flex-col justify-between">
    <div>
        <div class="w-full aspect-[4/3] overflow-hidden rounded-xl flex justify-center items-center">
            <img loading="lazy" class="w-full" src="{{ Storage::url($series->contents->first()->preview) }}" alt="" />
        </div>
        <div class="px-2 pt-2 md:px-3 md:pt-3">
            @include('insight.components.card-channel', [
                'name' => $series->channel->name,
                'logo' => $series->channel->logo,
                'slug' => $series->channel->slug,
                'subscribers' => $series->channel->active_subscribers_count,
            ])
            <h3 class="mt-2 sm:mt-3 text-sm sm:text-base lg:text-sm xl:text-base font-bold text-gray-800 dark:text-gray-200 h-8">
                {{ $series->name }}</h3>
        </div>
    </div>
    <div class="p-2 md:p-3 mt-1 xs:mt-2">
        <div class="flex items-center justify-between">
            <p class="date-transform text-xxs sm:text-xs text-gray-500" data-type="adaptive"
                data-date="{{ $series->contents->first()->created_at }}"></p>
        </div>
        <a class="block ml-auto sm:w-full mt-2"
            href="{{ route('insight.channel.series.show', ['channel' => $series->channel->slug, 'series' => $series->id . '-' . mb_strtolower(str_replace(' ', '-', $series->title))]) }}">
            <x-secondary-button class="w-full justify-center">{{ __('Open') }}</x-secondary-button>
        </a>
    </div>
</div>
