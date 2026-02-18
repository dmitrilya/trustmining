<div class="p-2 sm:p-4 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow shadow-logo-color rounded-xl">
    <h2
        class="mb-2 sm:mb-3 lg:mb-6 text-base text-gray-700 dark:text-gray-300 font-bold">
        {{ __('Top channels by views') }}
    </h2>

    @inject('channelService', 'App\Services\Insight\ChannelService')

    @foreach ($channelService->getTopChannels() as $channel)
        @include('insight.components.channel', [
            'name' => $channel->name,
            'slug' => $channel->slug,
            'logo' => $channel->logo,
            'subscribers' => $channel->active_subscribers_count,
            'sm' => true,
            'clickable' => true
        ])
    @endforeach
</div>
