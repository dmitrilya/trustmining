<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex justify-between h-12 sm:h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="text-xl sm:h-2xl" />
                    </a>
                </div>

                <div class="hidden space-x-4 lg:space-x-8 md:-my-px md:ml-10 md:flex">
                    <div class="relative flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 transition duration-150 ease-in-out"
                        x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false"
                        @mouseover="open = true" @mouseleave="open = false">
                        <button
                            class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ __('Advertisements') }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute z-50 w-max rounded-md shadow-lg origin-bottom-left"
                            style="display: none;top:100%" @click="open = false">
                            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-4 bg-white dark:bg-gray-700">
                                <x-dropdown-link :href="route('ads')" class="px-6 group flex items-center">
                                    <svg class="h-4 w-4 text-gray-400 group-hover:text-indigo-600 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m7.164 3.805-4.475.38L.327 6.546a1.114 1.114 0 0 0 .63 1.89l3.2.375 3.007-5.006ZM11.092 15.9l.472 3.14a1.114 1.114 0 0 0 1.89.63l2.36-2.362.38-4.475-5.102 3.067Zm8.617-14.283A1.613 1.613 0 0 0 18.383.291c-1.913-.33-5.811-.736-7.556 1.01-1.98 1.98-6.172 9.491-7.477 11.869a1.1 1.1 0 0 0 .193 1.316l.986.985.985.986a1.1 1.1 0 0 0 1.316.193c2.378-1.3 9.889-5.5 11.869-7.477 1.746-1.745 1.34-5.643 1.01-7.556Zm-3.873 6.268a2.63 2.63 0 1 1-3.72-3.72 2.63 2.63 0 0 1 3.72 3.72Z">
                                        </path>
                                    </svg>
                                    {{ __('Miners') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('hostings')" class="px-6 group flex items-center">
                                    <svg class="h-4 w-4 text-gray-400 group-hover:text-indigo-600 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    {{ __('Hostings') }}
                                </x-dropdown-link>
                            </div>
                        </div>
                    </div>

                    <x-nav-link :href="route('support')">
                        {{ __('Support') }}
                    </x-nav-link>

                    @include('layouts.components.solutions', [
                        'classes' =>
                            'inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150',
                    ])
                </div>
            </div>
            <div class="flex items-center">
                @auth
                    @php
                        $auth = Auth::user();
                    @endphp

                    <div class="mr-4"><x-notifications :notifications="$auth
                        ->notifications()
                        ->with(['notificationType', 'notificationable'])
                        ->latest()
                        ->take(5)
                        ->get()"></x-notifications></div>

                    <div class="mr-4 w-5 h-5">
                        <a
                            href="{{ route('chats') }}"class="relative inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400">
                            <svg class="w-5 h-5 me-2.5" aria-hidden="true" viewBox="0 0 20 18" fill="currentColor">
                                <path
                                    d="M18 4H16V9C16 10.0609 15.5786 11.0783 14.8284 11.8284C14.0783 12.5786 13.0609 13 12 13H9L6.846 14.615C7.17993 14.8628 7.58418 14.9977 8 15H11.667L15.4 17.8C15.5731 17.9298 15.7836 18 16 18C16.2652 18 16.5196 17.8946 16.7071 17.7071C16.8946 17.5196 17 17.2652 17 17V15H18C18.5304 15 19.0391 14.7893 19.4142 14.4142C19.7893 14.0391 20 13.5304 20 13V6C20 5.46957 19.7893 4.96086 19.4142 4.58579C19.0391 4.21071 18.5304 4 18 4Z"
                                    fill="currentColor" />
                                <path
                                    d="M12 0H2C1.46957 0 0.960859 0.210714 0.585786 0.585786C0.210714 0.960859 0 1.46957 0 2V9C0 9.53043 0.210714 10.0391 0.585786 10.4142C0.960859 10.7893 1.46957 11 2 11H3V13C3 13.1857 3.05171 13.3678 3.14935 13.5257C3.24698 13.6837 3.38668 13.8114 3.55279 13.8944C3.71889 13.9775 3.90484 14.0126 4.08981 13.996C4.27477 13.9793 4.45143 13.9114 4.6 13.8L8.333 11H12C12.5304 11 13.0391 10.7893 13.4142 10.4142C13.7893 10.0391 14 9.53043 14 9V2C14 1.46957 13.7893 0.960859 13.4142 0.585786C13.0391 0.210714 12.5304 0 12 0Z"
                                    fill="currentColor" />
                            </svg>

                            @if ($uncheckedMessagesCount = App\Models\Message::whereIn('chat_id', $auth->chats()->pluck('id'))->where('user_id', '!=', $auth->id)->where('checked', false)->count())
                                <div id="notifications-signal"
                                    class="absolute w-4 h-4 flex items-center justify-center bg-red-500 border-2 border-white rounded-full -top-1 start-2.5 dark:border-gray-900">
                                    <div class="text-white text-xxs">{{ $uncheckedMessagesCount < 100 ? $uncheckedMessagesCount : 99 }}</div>
                                </div>
                            @endif
                        </a>
                    </div>
                @endauth

                {{-- <div class="flex cursor-pointer mx-3">
                    <a class="{{ app()->getLocale() == 'ru' ? 'bg-primary-gradient hover:bg-gray-700 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }} p-1 rounded-l border border-r-0 border-gray-300 text-xxs font-semibold"
                        href="{{ route('locale', ['locale' => 'ru']) }}">RU</a>
                    <a class="{{ app()->getLocale() == 'en' ? 'bg-gray-800 hover:bg-gray-700 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }} p-1 rounded-r border border-l-0 border-gray-300 text-xxs font-semibold"
                        href="{{ route('locale', ['locale' => 'en']) }}">EN</a>
                </div> --}}

                <div class="hidden md:flex md:items-center md:ml-3">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ $auth->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
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

                                @if ($auth->ads->count())
                                    <x-dropdown-link :href="route('company', ['user' => $auth->url_name])">
                                        {{ __('My shop') }}
                                    </x-dropdown-link>
                                @endif

                                <x-dropdown-link :href="route('company.reviews', ['user' => $auth->url_name])">
                                    {{ __('Reviews') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('notifications')">
                                    {{ __('Notifications') }}
                                </x-dropdown-link>

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
                <div class="-mr-2 flex items-center md:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
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
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <div class="relative block w-full pl-3 pr-4 py-2 border-l-4 border-transparent hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out"
                x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false"
                @click="open = ! open">
                <button
                    class="inline-flex items-center text-left text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 focus:text-gray-800 dark:focus:text-gray-200 focus:outline-none transition ease-in-out duration-150">
                    <div>{{ __('Advertisements') }}</div>

                    <div class="ml-1">
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute z-50 w-max rounded-md shadow-lg origin-bottom-left" style="display: none;top:100%"
                    @click="open = false">
                    <div class="rounded-md ring-1 ring-black ring-opacity-5 py-3 bg-white dark:bg-gray-700">
                        <x-dropdown-link :href="route('ads')" class="px-5 group flex items-center">
                            <svg class="h-4 w-4 text-gray-400 group-hover:text-indigo-600 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m7.164 3.805-4.475.38L.327 6.546a1.114 1.114 0 0 0 .63 1.89l3.2.375 3.007-5.006ZM11.092 15.9l.472 3.14a1.114 1.114 0 0 0 1.89.63l2.36-2.362.38-4.475-5.102 3.067Zm8.617-14.283A1.613 1.613 0 0 0 18.383.291c-1.913-.33-5.811-.736-7.556 1.01-1.98 1.98-6.172 9.491-7.477 11.869a1.1 1.1 0 0 0 .193 1.316l.986.985.985.986a1.1 1.1 0 0 0 1.316.193c2.378-1.3 9.889-5.5 11.869-7.477 1.746-1.745 1.34-5.643 1.01-7.556Zm-3.873 6.268a2.63 2.63 0 1 1-3.72-3.72 2.63 2.63 0 0 1 3.72 3.72Z">
                                </path>
                            </svg>
                            {{ __('Miners') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('hostings')" class="px-5 group flex items-center">
                            <svg class="h-4 w-4 text-gray-400 group-hover:text-indigo-600 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            {{ __('Hostings') }}
                        </x-dropdown-link>
                    </div>
                </div>
            </div>

            <x-responsive-nav-link :href="route('support')">
                {{ __('Support') }}
            </x-responsive-nav-link>

            @include('layouts.components.solutions', [
                'relative' => true,
                'classes' =>
                    'flex items-center w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out',
            ])
        </div>

        <div class="py-3 border-t border-gray-200 dark:border-gray-600">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ $auth->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ $auth->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @if ($auth->ads->count())
                        <x-responsive-nav-link :href="route('company', ['user' => $auth->url_name])">
                            {{ __('My shop') }}
                        </x-responsive-nav-link>
                    @endif

                    <x-responsive-nav-link :href="route('company.reviews', ['user' => $auth->url_name])">
                        {{ __('Reviews') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('notifications')">
                        {{ __('Notifications') }}
                    </x-responsive-nav-link>

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
