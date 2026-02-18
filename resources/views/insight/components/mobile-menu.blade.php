<nav
    class="fixed z-50 bottom-0 lg:hidden w-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 backdrop-blur-2xl rounded-t-xl border-t border-gray-100 dark:border-zinc-800 px-2 sm:px-4 md:px-6 py-1.5">
    <div class="flex items-center justify-around">
        @php
            $strokeWidth = '1.5';
        @endphp
        <a href="{{ route('insight.index') }}" class="flex flex-col items-center">
            @if (request()->routeIs('insight.index'))
                @include('insight.svg.home-active', [
                    'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-800 dark:text-gray-200">
                    {{ __('Home') }}
                </div>
            @else
                @include('insight.svg.home', [
                    'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-600 dark:text-gray-400">
                    {{ __('Home') }}
                </div>
            @endif
        </a>
        <a href="{{ route('insight.post.index') }}" class="flex flex-col items-center">
            @if (request()->routeIs('insight.post.*'))
                @include('insight.svg.post-active', [
                    'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-800 dark:text-gray-200">
                    {{ __('Posts') }}
                </div>
            @else
                @include('insight.svg.post', [
                    'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-600 dark:text-gray-400">
                    {{ __('Posts') }}
                </div>
            @endif
        </a>
        <a href="{{ route('insight.video.index') }}" class="flex flex-col items-center">
            @if (request()->routeIs('insight.video.*'))
                @include('insight.svg.video-active', [
                    'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-800 dark:text-gray-200">
                    {{ __('Videos') }}
                </div>
            @else
                @include('insight.svg.video', [
                    'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-600 dark:text-gray-400">
                    {{ __('Videos') }}
                </div>
            @endif
        </a>
        <a href="{{ route('insight.subscriptions.index') }}" class="flex flex-col items-center">
            @if (request()->routeIs('insight.subscriptions.*'))
                @include('insight.svg.subscriptions-active', [
                    'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-800 dark:text-gray-200">
                    {{ __('Subscriptions') }}
                </div>
            @else
                @include('insight.svg.subscriptions', [
                    'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-600 dark:text-gray-400">
                    {{ __('Subscriptions') }}
                </div>
            @endif
        </a>
        <a href="{{ route('insight.article.index') }}" class="flex flex-col items-center">
            @if (request()->routeIs('insight.article.*'))
                @include('insight.svg.article-active', [
                    'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-800 dark:text-gray-200">
                    {{ __('Articles') }}
                </div>
            @else
                @include('insight.svg.article', [
                    'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-600 dark:text-gray-400">
                    {{ __('Articles') }}
                </div>
            @endif
        </a>
        <a @if (auth()->check()) href="{{ auth()->user()->channel ? route('insight.channel.show', ['channel' => auth()->user()->channel->slug]) : route('insight.channel.create') }}" @else href="#" @click="$dispatch('open-modal', 'login')" @endif
            class="flex flex-col items-center">
            @if (
                (request()->routeIs('insight.channel.*') && $channel && auth()->check() && auth()->user()->id == $channel->user_id) ||
                    request()->routeIs('insight.channel.create'))
                @include('insight.svg.channel-active', [
                    'svgClass' => 'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-800 dark:text-gray-200">
                    {{ __('My channel') }}
                </div>
            @else
                @include('insight.svg.channel', [
                    'svgClass' => 'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-7 sm:size-9',
                ])

                <div class="mt-0.5 sm:mt-1 text-xxs xs:text-xs text-gray-600 dark:text-gray-400">
                    {{ __('My channel') }}
                </div>
            @endif
        </a>
    </div>
</nav>
