<x-app-layout :title="$attributes->get('title')" :description="$attributes->get('description')" without_footer="true" :itemtype="$attributes->get('itemtype')" :itemname="$attributes->get('itemname')"
    :noindex="$attributes->has('noindex') ? 'true' : null">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
                {{ $attributes->get('header') }}
            </h1>

            <div class="flex items-center">
                @if (isset($sort))
                    {{ $sort }}
                @endif

                <div x-data="{ open: false }" @click.outside="open = false"
                    class="relative inline-block ml-1 xs:ml-2 sm:ml-3 lg:ml-4">
                    <div @if (auth()->check() && auth()->user()->channel) @click="open = !open" @elseif (auth()->check()) @click="window.open('{{ route('insight.channel.create') }}', '_blank')" @else @click="$dispatch('open-modal', 'login')" @endif
                        class="group flex items-center cursor-pointer rounded-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-sm hover:shadow-md shadow-logo-color hover:shadow-logo-color px-3 py-1.5 sm:px-4 sm:py-2 transition-all active:scale-95">

                        <svg class="hidden xs:block text-slate-600 dark:text-slate-400 stroke-slate-400 dark:stroke-slate-600 group-hover:text-slate-800 dark:group-hover:text-slate-200 size-4 sm:size-5"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>

                        <div
                            class="ml-1 text-xs sm:text-sm text-slate-600 dark:text-slate-400 group-hover:text-slate-800 dark:group-hover:text-slate-200">
                            {{ __('Publish') }}
                        </div>
                    </div>

                    @if (auth()->check() && auth()->user()->channel)
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                            class="absolute right-0 mt-2 w-48 origin-top-left rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl shadow-xl z-50 overflow-hidden"
                            style="display: none;">

                            @include('insight.components.publish-menu')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    @if (isset($og))
        <x-slot name="og">
            {{ $og }}
        </x-slot>
    @endif

    <div class="max-w-10xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid grid-cols-12 gap-4 items-start relative">
            <div class="hidden lg:flex flex-col lg:col-span-3 xl:col-span-2 gap-4">
                @include('insight.components.menu', ['channel' => $attributes->get('channel')])

                @if (isset($leftSidebar))
                    {{ $leftSidebar }}
                @endif

                @include('insight.components.popular-article')
            </div>

            <div class="lg:col-span-6 xl:col-span-7">
                {{ $slot }}
            </div>

            <div class="hidden lg:flex flex-col lg:col-span-3 gap-4">
                @include('insight.components.top-channels')

                <div id="toc-lg-container"></div>

                @if (isset($rightSidebar))
                    {{ $rightSidebar }}
                @endif
            </div>
        </div>
    </div>

    @include('insight.components.mobile-menu', ['channel' => $attributes->get('channel')])

    @include('insight.components.auth.login')
    @include('insight.components.auth.register')
</x-app-layout>
