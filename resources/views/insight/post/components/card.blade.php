<div itemprop="item" itemscope itemtype="https://schema.org/SocialMediaPosting"
    class="card relative sm:max-w-md h-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-hidden rounded-xl flex flex-col justify-between">
    <div>
        <div class="w-full aspect-[4/3] overflow-hidden rounded-xl flex justify-center items-center">
            <img itemprop="image" class="w-full" src="{{ Storage::url($post->preview) }}" alt="Post preview" />
        </div>
        <div class="px-2 pt-2 md:px-3 md:pt-3">
            @include('insight.components.card-channel', [
                'name' => $post->channel->name,
                'logo' => $post->channel->logo,
                'slug' => $post->channel->slug,
                'subscribers' => $post->channel->active_subscribers_count,
            ])
            <div itemprop="articleBody"
                class="ql-editor !p-0 mt-2 sm:mt-3 text-xs text-gray-700 dark:text-gray-300 h-16 overflow-hidden line-clamp-4">
                {!! $post->content !!}</div>
        </div>
    </div>
    <div class="p-2 md:p-3 mt-1 xs:mt-2">
        <div class="flex items-center justify-between">
            <p class="date-transform text-xxs sm:text-xs text-gray-500" data-type="adaptive"
                data-date="{{ $post->created_at }}"></p>
            <meta itemprop="datePublished" content="{{ $post->created_at->format('Y-m-d') }}" />

            <div class="flex items-center gap-2 xs:gap-3 sm:gap-4">
                <div itemprop="interactionStatistic" itemscope itemtype="https://schema.org/InteractionCounter"
                    class="flex items-center">
                    <svg class="w-3 h-3 xs:w-4 xs:h-4 text-gray-700 dark:text-white" aria-hidden="true" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z"
                            clip-rule="evenodd" />
                    </svg>

                    <meta itemprop="interactionType" content="https://schema.org/LikeAction" />
                    <p itemprop="userInteractionCount" class="text-xxs sm:text-xs text-gray-500 ml-1 xs:ml-2">
                        {{ $post->likes_count }}
                    </p>
                </div>

                <div itemprop="interactionStatistic" itemscope itemtype="https://schema.org/InteractionCounter"
                    class="flex items-center">
                    <svg class="w-3 h-3 xs:w-4 xs:h-4 text-gray-700 dark:text-white" aria-hidden="true" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            clip-rule="evenodd" />
                    </svg>

                    <meta itemprop="interactionType" content="https://schema.org/ViewAction" />
                    <p itemprop="userInteractionCount" class="text-xxs sm:text-xs text-gray-500 ml-1 xs:ml-2">
                        {{ $post->views_count }}</p>
                </div>
            </div>
        </div>
        <a itemprop="url" class="block ml-auto sm:w-full mt-2"
            href="{{ route('insight.post.show', ['channel' => $post->channel->slug, 'post' => $post->id]) }}">
            <x-secondary-button class="w-full justify-center">{{ __('Read') }}</x-secondary-button>
        </a>
    </div>
</div>
