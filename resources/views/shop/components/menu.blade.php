<div class="relative" x-data="{ open: false }"">
    <button @click="open = ! open"
        class="ml-2 sm:ml-3 lg:ml-4 inline-flex items-center border border-transparent text-sm leading-4 rounded-md text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
        <div>{{ __('Details') }}</div>

        <div class="ml-1">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
            </svg>
        </div>
    </button>

    <div x-show="open" class="absolute z-20 mt-5 flex max-w-md overflow-hidden rounded-3xl backdrop-blur-2xl" style="width: calc(100vw - 2rem);display: none"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1"
        @click.away="open = false">
        <div
            class="w-full flex-auto bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 text-sm leading-6 shadow-lg shadow-logo-color ring-1 ring-gray-900/5 dark:ring-zinc-200/5">
            <div class="p-4">
                <a href="{{ route('company', ['user' => $user->url_name]) }}"
                    class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-zinc-800">
                    <div
                        class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 dark:bg-zinc-950 group-hover:bg-white dark:group-hover:bg-zinc-900">
                        <svg class="h-6 w-6 text-gray-700 dark:text-gray-300 group-hover:text-indigo-600"
                            aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1M5 12h14M5 12a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1m-2 3h.01M14 15h.01M17 9h.01M14 9h.01" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-950 dark:text-gray-50">
                            {{ __('Advertisements') }}
                            <span class="absolute inset-0"></span>
                        </div>
                        <p class="mt-1 text-gray-700 dark:text-gray-300">{{ __('Current price') }}</p>
                    </div>
                </a>
                <a href="{{ $user->company && !$user->company->moderation ? route('company.about', ['user' => $user->url_name]) : '#' }}"
                    class="group relative flex gap-x-6 rounded-lg p-4 {{ !$user->company || $user->company->moderation ? 'opacity-60' : 'hover:bg-gray-50 dark:hover:bg-zinc-800' }}">
                    <div
                        class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 dark:bg-zinc-950 group-hover:bg-white dark:group-hover:bg-zinc-900">
                        <svg class="h-6 w-6 text-gray-700 dark:text-gray-300 group-hover:text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.864 4.243A7.5 7.5 0 0119.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 004.5 10.5a7.464 7.464 0 01-1.15 3.993m1.989 3.559A11.209 11.209 0 008.25 10.5a3.75 3.75 0 117.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 01-3.6 9.75m6.633-4.596a18.666 18.666 0 01-2.485 5.33" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-950 dark:text-gray-50">
                            {{ __('About company') }}
                            <span class="absolute inset-0"></span>
                        </div>
                        <p class="mt-1 text-gray-700 dark:text-gray-300">{{ __('Information and documents') }}</p>
                    </div>
                </a>
                <a href="{{ $user->hosting && !$user->hosting->moderation ? route('company.hosting', ['user' => $user->url_name]) : '#' }}"
                    class="group relative flex gap-x-6 rounded-lg p-4 {{ !$user->hosting || $user->hosting->moderation ? 'opacity-60' : 'hover:bg-gray-50 dark:hover:bg-zinc-800' }}">
                    <div
                        class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 dark:bg-zinc-950 group-hover:bg-white dark:group-hover:bg-zinc-900">
                        <svg class="h-6 w-6 text-gray-700 dark:text-gray-300 group-hover:text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-950 dark:text-gray-50">
                            {{ __('Hosting') }}
                            <span class="absolute inset-0"></span>
                        </div>
                        <p class="mt-1 text-gray-700 dark:text-gray-300">
                            {{ $user->hosting && !$user->hosting->moderation ? __('Placement data') : __('No information about placement') }}
                        </p>
                    </div>
                </a>
                <a href="{{ route('company.offices', ['user' => $user->url_name]) }}"
                    class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-zinc-800">
                    <div
                        class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 dark:bg-zinc-950 group-hover:bg-white dark:group-hover:bg-zinc-900">
                        <svg class="w-6 h-6 text-gray-700 dark:text-gray-300 group-hover:text-indigo-600"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-950 dark:text-gray-50">
                            {{ __('Offices') }}
                            <span class="absolute inset-0"></span>
                        </div>
                        <p class="mt-1 text-gray-700 dark:text-gray-300">
                            {{ __('Offices and points of sale') }}
                        </p>
                    </div>
                </a>
                <a href="{{ route('company.reviews', ['user' => $user->url_name]) }}"
                    class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-zinc-800">
                    <div
                        class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 dark:bg-zinc-950 group-hover:bg-white dark:group-hover:bg-zinc-900">
                        <svg class="h-6 w-6 text-gray-700 dark:text-gray-300 group-hover:text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path
                                d="M7.71 3c1.78 0 3.34.87 4.29 2.21A5.22 5.22 0 0 1 16.29 3a5.73 5.73 0 0 1 4.1 9.73l-7.72 7.61a.95.95 0 0 1-1.34 0l-7.72-7.62A5.73 5.73 0 0 1 7.71 3Z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-950 dark:text-gray-50">
                            {{ __('Reviews') }}
                            <span class="absolute inset-0"></span>
                        </div>

                        <div class="flex items-center" x-data="{ momentRating: {{ $user->moderatedReviews->count() ? $user->moderatedReviews->avg('rating') : 0 }} }">
                            <x-rating></x-rating>

                            <p class="ml-3 text-sm text-indigo-600 hover:text-indigo-500">
                                {{ $user->moderatedReviews->count() }} {{ __('reviews') }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-2 divide-x divide-gray-900/5 dark:divide-zinc-700 bg-gray-50 dark:bg-zinc-800">
                <a target="_blank" href="{{ route('chat.start', ['user' => $user->id]) }}"
                    class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-950 dark:text-gray-50 hover:bg-gray-100 dark:hover:bg-zinc-900">
                    <svg class="h-5 w-5 flex-none text-gray-500 dark:text-gray-400" aria-hidden="true"
                        viewBox="0 0 20 18" fill="currentColor">
                        <path
                            d="M18 4H16V9C16 10.0609 15.5786 11.0783 14.8284 11.8284C14.0783 12.5786 13.0609 13 12 13H9L6.846 14.615C7.17993 14.8628 7.58418 14.9977 8 15H11.667L15.4 17.8C15.5731 17.9298 15.7836 18 16 18C16.2652 18 16.5196 17.8946 16.7071 17.7071C16.8946 17.5196 17 17.2652 17 17V15H18C18.5304 15 19.0391 14.7893 19.4142 14.4142C19.7893 14.0391 20 13.5304 20 13V6C20 5.46957 19.7893 4.96086 19.4142 4.58579C19.0391 4.21071 18.5304 4 18 4Z"
                            fill="currentColor" />
                        <path
                            d="M12 0H2C1.46957 0 0.960859 0.210714 0.585786 0.585786C0.210714 0.960859 0 1.46957 0 2V9C0 9.53043 0.210714 10.0391 0.585786 10.4142C0.960859 10.7893 1.46957 11 2 11H3V13C3 13.1857 3.05171 13.3678 3.14935 13.5257C3.24698 13.6837 3.38668 13.8114 3.55279 13.8944C3.71889 13.9775 3.90484 14.0126 4.08981 13.996C4.27477 13.9793 4.45143 13.9114 4.6 13.8L8.333 11H12C12.5304 11 13.0391 10.7893 13.4142 10.4142C13.7893 10.0391 14 9.53043 14 9V2C14 1.46957 13.7893 0.960859 13.4142 0.585786C13.0391 0.210714 12.5304 0 12 0Z"
                            fill="currentColor" />
                    </svg>
                    {{ __('Chat') }}
                </a>
                <a href="#"
                    class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-950 dark:text-gray-50 hover:bg-gray-100 dark:hover:bg-zinc-900">
                    <svg class="h-5 w-5 flex-none text-gray-500 dark:text-gray-400" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __('Call') }}
                </a>
            </div>
        </div>
    </div>
</div>
