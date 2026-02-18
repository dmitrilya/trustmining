<div
    class="bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-sm shadow-logo-color rounded-xl py-1 sm:px-1 sm:py-2 md:px-3 md:py-4">
    @php
        $strokeWidth = '2';
    @endphp

    @if (request()->routeIs('insight.index'))
        <a href="{{ route('insight.index') }}"
            class="flex items-center group bg-gray-100 dark:bg-zinc-800 px-3 py-2 rounded-full">
            @include('insight.svg.home-active', [
                'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-6',
            ])

            <div class="ml-1.5 sm:ml-2 text-base text-gray-800 dark:text-gray-200">
                {{ __('Home') }}
            </div>
        </a>
    @else
        <a href="{{ route('insight.index') }}" class="flex items-center group px-3 py-2">
            @include('insight.svg.home', [
                'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-6',
            ])

            <div
                class="ml-1.5 sm:ml-2 text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:dark:text-gray-200">
                {{ __('Home') }}
            </div>
        </a>
    @endif
    @if (request()->routeIs('insight.post.*'))
        <a href="{{ route('insight.post.index') }}"
            class="flex items-center group bg-gray-100 dark:bg-zinc-800 px-3 py-2 rounded-full">
            @include('insight.svg.post-active', [
                'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-6',
            ])

            <div class="ml-1.5 sm:ml-2 text-base text-gray-800 dark:text-gray-200">
                {{ __('Posts') }}
            </div>
        </a>
    @else
        <a href="{{ route('insight.post.index') }}" class="flex items-center group px-3 py-2">
            @include('insight.svg.post', [
                'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-6',
            ])

            <div
                class="ml-1.5 sm:ml-2 text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:dark:text-gray-200">
                {{ __('Posts') }}
            </div>
        </a>
    @endif
    @if (request()->routeIs('insight.video.*'))
        <a href="{{ route('insight.video.index') }}"
            class="flex items-center group bg-gray-100 dark:bg-zinc-800 px-3 py-2 rounded-full">
            @include('insight.svg.video-active', [
                'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-6',
            ])

            <div class="ml-1.5 sm:ml-2 text-base text-gray-800 dark:text-gray-200">
                {{ __('Videos') }}
            </div>
        </a>
    @else
        <a href="{{ route('insight.video.index') }}" class="flex items-center group px-3 py-2">
            @include('insight.svg.video', [
                'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-6',
            ])

            <div
                class="ml-1.5 sm:ml-2 text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:dark:text-gray-200">
                {{ __('Videos') }}
            </div>
        </a>
    @endif
    @if (request()->routeIs('insight.subscriptions.*'))
        <a href="{{ route('insight.subscriptions.index') }}"
            class="flex items-center group bg-gray-100 dark:bg-zinc-800 px-3 py-2 rounded-full">
            @include('insight.svg.subscriptions-active', [
                'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-6',
            ])

            <div class="ml-1.5 sm:ml-2 text-base text-gray-800 dark:text-gray-200">
                {{ __('Subscriptions') }}
            </div>
        </a>
    @else
        <a href="{{ route('insight.subscriptions.index') }}" class="flex items-center group px-3 py-2">
            @include('insight.svg.subscriptions', [
                'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-6',
            ])

            <div
                class="ml-1.5 sm:ml-2 text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:dark:text-gray-200">
                {{ __('Subscriptions') }}
            </div>
        </a>
    @endif
    @if (request()->routeIs('insight.article.*'))
        <a href="{{ route('insight.article.index') }}"
            class="flex items-center group bg-gray-100 dark:bg-zinc-800 px-3 py-2 rounded-full">
            @include('insight.svg.article-active', [
                'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-6',
            ])

            <div class="ml-1.5 sm:ml-2 text-base text-gray-800 dark:text-gray-200">
                {{ __('Articles') }}
            </div>
        </a>
    @else
        <a href="{{ route('insight.article.index') }}" class="flex items-center group px-3 py-2">
            @include('insight.svg.article', [
                'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-6',
            ])

            <div
                class="ml-1.5 sm:ml-2 text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:dark:text-gray-200">
                {{ __('Articles') }}
            </div>
        </a>
    @endif
    @if (
        (request()->routeIs('insight.channel.*') && $channel && auth()->check() && auth()->user()->id == $channel->user_id) ||
            request()->routeIs('insight.channel.create'))
        <a @if (auth()->check()) href="{{ auth()->user()->channel ? route('insight.channel.show', ['channel' => auth()->user()->channel->slug]) : route('insight.channel.create') }}" @else href="#" @click="$dispatch('open-modal', 'login')" @endif
            class="flex items-center group bg-gray-100 dark:bg-zinc-800 px-3 py-2 rounded-full">
            @include('insight.svg.channel-active', [
                'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-6',
            ])

            <div class="ml-1.5 sm:ml-2 text-base text-gray-800 dark:text-gray-200">
                {{ __('My channel') }}
            </div>
        </a>
    @else
        <a @if (auth()->check()) href="{{ auth()->user()->channel ? route('insight.channel.show', ['channel' => auth()->user()->channel->slug]) : route('insight.channel.create') }}" @else href="#" @click="$dispatch('open-modal', 'login')" @endif
            class="flex items-center group px-3 py-2">
            @include('insight.svg.channel', [
                'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-6',
            ])

            <div
                class="ml-1.5 sm:ml-2 text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:dark:text-gray-200">
                {{ __('My channel') }}
            </div>
        </a>
    @endif
    @if (request()->routeIs(['insight.channel.*', 'insight.channel.statistics']) && $channel && auth()->check() &&
            auth()->user()->id == $channel->user_id)
        <div class="px-3 pt-4 pb-2 mt-2 border-t border-gray-300 dark:border-zinc-700 cursor-pointer group"
            x-data="{ open: false }">
            <div class="flex items-center" @click="open = !open">
                <svg :class="open ? 'text-gray-800 dark:text-gray-200' : 'text-gray-600 dark:text-gray-400'"
                    class="stroke-gray-400 dark:stroke-zinc-600 size-6" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                </svg>


                <div :class="open ? 'text-gray-800 dark:text-gray-200' : 'text-gray-600 dark:text-gray-400'"
                    class="ml-1.5 sm:ml-2 text-base group-hover:text-gray-800 dark:group-hover:dark:text-gray-200">
                    {{ __('Publish') }}
                </div>
            </div>

            <div x-show="open" x-collapse class="pl-8 space-y-1 mt-2" style="display: none;">
                <a href="{{ route('insight.article.create', ['channel' => $channel->slug]) }}"
                    class="block text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">{{ __('Article') }}</a>
                <a href="{{ route('insight.post.create', ['channel' => $channel->slug]) }}"
                    class="block text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">{{ __('Post') }}</a>
                <a href="{{ route('insight.video.create', ['channel' => $channel->slug]) }}"
                    class="block text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">{{ __('Video') }}</a>
            </div>
        </div>

        <div class="px-3 py-2 cursor-pointer group">
            <div class="flex items-center" @click="$dispatch('open-modal', 'series-creation')">
                <svg class="text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-6"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="{{ $strokeWidth }}"
                        d="M14 17h6m-3 3v-6M4.857 4h4.286c.473 0 .857.384.857.857v4.286a.857.857 0 0 1-.857.857H4.857A.857.857 0 0 1 4 9.143V4.857C4 4.384 4.384 4 4.857 4Zm10 0h4.286c.473 0 .857.384.857.857v4.286a.857.857 0 0 1-.857.857h-4.286A.857.857 0 0 1 14 9.143V4.857c0-.473.384-.857.857-.857Zm-10 10h4.286c.473 0 .857.384.857.857v4.286a.857.857 0 0 1-.857.857H4.857A.857.857 0 0 1 4 19.143v-4.286c0-.473.384-.857.857-.857Z" />
                </svg>

                <div
                    class="ml-1.5 sm:ml-2 text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:dark:text-gray-200">
                    {{ __('Create series') }}
                </div>
            </div>
        </div>

        @if (request()->routeIs('insight.channel.statistics'))
            <a href="{{ route('insight.channel.statistics', ['channel' => $channel->slug]) }}"
                class="flex items-center group bg-gray-100 dark:bg-zinc-800 px-3 py-2 rounded-full">
                @include('insight.svg.statistics-active', [
                    'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-6',
                ])

                <div class="ml-1.5 sm:ml-2 text-base text-gray-800 dark:text-gray-200">
                    {{ __('Statistics') }}
                </div>
            </a>
        @else
            <a href="{{ route('insight.channel.statistics', ['channel' => $channel->slug]) }}"
                class="flex items-center group px-3 py-2">
                @include('insight.svg.statistics', [
                    'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-6',
                ])

                <div
                    class="ml-1.5 sm:ml-2 text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:dark:text-gray-200">
                    {{ __('Statistics') }}
                </div>
            </a>
        @endif
    @endif
</div>
