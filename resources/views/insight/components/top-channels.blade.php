<div
    class="p-2 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl">
    <h2 class="mb-2 sm:mb-3 lg:mb-6 text-base text-slate-700 dark:text-slate-300 font-bold">
        {{ __('Top channels by views') }}
    </h2>

    @inject('channelService', 'App\Services\Insight\ChannelService')

    @foreach ($channelService->getTopChannels() as $channel)
        <div itemscope itemtype="https://schema.org/Organization">
            @include('insight.components.channel', [
                'name' => $channel->name,
                'slug' => $channel->slug,
                'logo' => $channel->logo,
                'subscribers' => $channel->active_subscribers_count,
                'sm' => true,
                'clickable' => true,
            ])
        </div>
    @endforeach
</div>
