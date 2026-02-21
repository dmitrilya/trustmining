@if (!$user)
    <x-primary-button @click="$dispatch('open-modal', 'login')">
        {{ __('Subscribe') }}
    </x-primary-button>
@elseif ($user->id != $channel->user_id)
    <div itemprop="potentialAction" itemscope itemtype="https://schema.org/FollowAction">
        <x-primary-button itemprop="target"
            @click="channelToggleSubscription($el, '{{ route('insight.channel.subscription', ['channel' => $channel->slug]) }}')">
            {{ $channel->activeSubscribers()->wherePivot('user_id', $user->id)->exists() ? __('Unsubscribe') : __('Subscribe') }}
        </x-primary-button>
    </div>
@else
    <div class="flex items-center">
        <div class="mr-2 text-xxs sm:text-xs lg:text-sm text-gray-500 flex items-center" @click="edit = !edit">
            <svg class="size-5 sm:size-6 lg:size-7 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 cursor-pointer"
                aria-hidden="true" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
            </svg>
        </div>

        <div class="text-xxs sm:text-xs lg:text-sm text-gray-500 flex items-center"
            @click="$dispatch('open-modal', 'delete-modal')">
            <svg class="size-5 sm:size-6 lg:size-7 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 cursor-pointer"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" height="24" fill="none" viewBox="0 0 26 26">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" height="18.67px"
                    stroke-width="1.5"
                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
            </svg>
        </div>
    </div>
@endif
