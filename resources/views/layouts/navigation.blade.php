<nav x-data="{ open: false }" class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 border-b border-slate-100 dark:border-slate-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-2 xs:px-4 sm:px-6 lg:px-8 py-1">
        <div class="flex justify-between h-10 lg:h-14">
            <div class="w-full flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="text-sm xs:text-xl" />
                    </a>
                </div>

                <div class="w-full hidden space-x-4 xl:space-x-8 -my-px ml-10 lg:flex items-center">
                    @include('layouts.components.ads', [
                        'classes' =>
                            'h-full inline-flex items-center border border-transparent text-sm leading-4 rounded-md text-slate-600 dark:text-slate-300 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none transition ease-in-out duration-150',
                    ])

                    @include('layouts.components.solutions', [
                        'classes' =>
                            'h-full inline-flex items-center border border-transparent text-sm leading-4 rounded-md text-slate-600 dark:text-slate-300 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none transition ease-in-out duration-150',
                    ])

                    <x-nav-link :href="route('support')">
                        {{ __('Support') }}
                    </x-nav-link>

                    @include('layouts.components.search', [
                        'border' => 'px-2.5 py-1.5 rounded-md border',
                        'searchBlock' => 'max-w-sm',
                    ])
                </div>
            </div>
            <div class="flex items-center ml-4 xl:ml-6">
                @auth
                    @php
                        $auth = Auth::user();
                        $uncheckedMessagesCount = App\Models\Chat\Message::whereIn(
                            'chat_id',
                            $auth->chats()->pluck('id'),
                        )
                            ->where('user_id', '!=', $auth->id)
                            ->where('checked', false)
                            ->count();
                    @endphp

                    <div class="mr-4"><x-notifications :notifications="$auth
                        ->notifications()
                        ->with(['notificationType', 'notificationable'])
                        ->latest()
                        ->take(5)
                        ->get()"></x-notifications></div>

                    <div class="mr-5 w-5 h-5">
                        <a aria-label="{{ __('Chats') }}"
                            href="{{ route('chats') }}"class="relative inline-flex items-center text-sm text-center text-slate-600 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400 focus:outline-none">
                            <svg class="w-5 h-5 me-2.5" aria-hidden="true" viewBox="0 0 20 18" fill="currentColor">
                                <path
                                    d="M18 4H16V9C16 10.0609 15.5786 11.0783 14.8284 11.8284C14.0783 12.5786 13.0609 13 12 13H9L6.846 14.615C7.17993 14.8628 7.58418 14.9977 8 15H11.667L15.4 17.8C15.5731 17.9298 15.7836 18 16 18C16.2652 18 16.5196 17.8946 16.7071 17.7071C16.8946 17.5196 17 17.2652 17 17V15H18C18.5304 15 19.0391 14.7893 19.4142 14.4142C19.7893 14.0391 20 13.5304 20 13V6C20 5.46957 19.7893 4.96086 19.4142 4.58579C19.0391 4.21071 18.5304 4 18 4Z"
                                    fill="currentColor" />
                                <path
                                    d="M12 0H2C1.46957 0 0.960859 0.210714 0.585786 0.585786C0.210714 0.960859 0 1.46957 0 2V9C0 9.53043 0.210714 10.0391 0.585786 10.4142C0.960859 10.7893 1.46957 11 2 11H3V13C3 13.1857 3.05171 13.3678 3.14935 13.5257C3.24698 13.6837 3.38668 13.8114 3.55279 13.8944C3.71889 13.9775 3.90484 14.0126 4.08981 13.996C4.27477 13.9793 4.45143 13.9114 4.6 13.8L8.333 11H12C12.5304 11 13.0391 10.7893 13.4142 10.4142C13.7893 10.0391 14 9.53043 14 9V2C14 1.46957 13.7893 0.960859 13.4142 0.585786C13.0391 0.210714 12.5304 0 12 0Z"
                                    fill="currentColor" />
                            </svg>

                            <div id="messages-signal"
                                class="{{ !$uncheckedMessagesCount ? 'hidden ' : '' }}absolute w-4 h-4 flex items-center justify-center bg-red-500 border-2 border-white rounded-full -top-1 start-2.5 dark:border-slate-900 text-white text-xxs">
                                {{ $uncheckedMessagesCount < 10 ? $uncheckedMessagesCount : '9+' }}
                            </div>
                        </a>
                    </div>
                @endauth

                <div class="flex cursor-pointer mr-3">
                    <div
                        class="{{ app()->getLocale() == 'ru' ? 'bg-primary-gradient text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-100' }} py-1 px-1.5 rounded-l border border-r-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold">
                        <a href="{{ route('locale', ['locale' => 'ru']) }}">RU</a>
                    </div>
                    <div
                        class="{{ app()->getLocale() == 'en' ? 'bg-primary-gradient text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-100' }} py-1 px-1.5 rounded-r border border-l-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold">
                        <a href="{{ route('locale', ['locale' => 'en']) }}">EN</a>
                    </div>

                </div>

                <div class="hidden lg:flex items-center ml-3">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center border border-transparent text-sm leading-4 rounded-md text-slate-600 dark:text-slate-300 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none transition ease-in-out duration-150">
                                    <div class="w-max">{{ $auth->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                @if ($auth->passport || $auth->company)
                                    <x-dropdown-link :href="route('company', ['user' => $auth->url_name])">
                                        {{ __('My shop') }}
                                    </x-dropdown-link>
                                @endif

                                @if ($auth->channel)
                                    <x-dropdown-link :href="route('insight.channel.show', ['channel' => $auth->channel->slug])">
                                        {{ __('My channel') }}
                                    </x-dropdown-link>
                                @endif

                                <x-dropdown-link :href="route('company.reviews', ['user' => $auth->url_name])">
                                    {{ __('Reviews') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('notifications')">
                                    {{ __('Notifications') }}
                                </x-dropdown-link>

                                @if ($auth->role_id == 3)
                                    <x-dropdown-link :href="route('moderations')">
                                        {{ __('Moderations') }}
                                    </x-dropdown-link>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Logout') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <x-nav-link :href="route('login')">
                            {{ __('Login') }}
                        </x-nav-link>
                    @endauth
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center lg:hidden">
                    <button @click="open = ! open" aria-label="{{ __('Menu') }}"
                        class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 dark:text-slate-400 hover:text-slate-500 dark:hover:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900 focus:outline-none focus:bg-slate-100 dark:focus:bg-slate-900 focus:text-slate-500 dark:focus:text-slate-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden lg:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <div class="px-4 py-2">
                @include('layouts.components.search')
            </div>

            @include('layouts.components.ads', [
                'relative' => true,
                'classes' =>
                    'flex items-center w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base text-slate-700 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-700 focus:outline-none focus:text-slate-800 dark:focus:text-slate-200 focus:bg-slate-50 dark:focus:bg-slate-800 focus:border-slate-400 dark:focus:border-slate-700 transition duration-150 ease-in-out',
            ])

            <x-responsive-nav-link :href="route('support')">
                {{ __('Support') }}
            </x-responsive-nav-link>

            @include('layouts.components.solutions', [
                'relative' => true,
                'classes' =>
                    'flex items-center w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base text-slate-700 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-700 focus:outline-none focus:text-slate-800 dark:focus:text-slate-200 focus:bg-slate-50 dark:focus:bg-slate-800 focus:border-slate-400 dark:focus:border-slate-700 transition duration-150 ease-in-out',
            ])
        </div>

        <div class="py-3 border-t border-slate-300 dark:border-slate-700">
            @auth
                <div class="px-4">
                    <div class="text-base text-slate-900 dark:text-slate-100">{{ $auth->name }}</div>
                    <div class="text-sm text-slate-600">{{ $auth->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @if ($auth->passport || $auth->company)
                        <x-responsive-nav-link :href="route('company', ['user' => $auth->url_name])">
                            {{ __('My shop') }}
                        </x-responsive-nav-link>
                    @endif

                    @if ($auth->channel)
                        <x-responsive-nav-link :href="route('insight.channel.show', ['channel' => $auth->channel->slug])">
                            {{ __('My channel') }}
                        </x-responsive-nav-link>
                    @endif

                    <x-responsive-nav-link :href="route('company.reviews', ['user' => $auth->url_name])">
                        {{ __('Reviews') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('notifications')">
                        {{ __('Notifications') }}
                    </x-responsive-nav-link>

                    @if ($auth->role_id == 3)
                        <x-responsive-nav-link :href="route('moderations')">
                            {{ __('Moderations') }}
                        </x-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Logout') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
            @endauth
        </div>
    </div>
</nav>
