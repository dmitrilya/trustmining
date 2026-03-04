<div class="mt-4 sm:mt-5 md:mt-6 lg:mt-7 grid grid-cols-4 sm:grid-cols-2 lg:grid-cols-4 gap-3">
    <a href="{{ route('company', ['user' => $user->url_name]) }}"
        class="group relative flex flex-col sm:flex-row items-center gap-2 sm:gap-4 rounded-lg">
        <div
            class="flex h-9 sm:h-11 w-9 sm:w-11 flex-none items-center justify-center rounded-lg bg-slate-50 dark:bg-slate-950">
            <svg class="h-5 sm:h-6 w-5 sm:w-6 {{ request()->routeIs('company') ? 'text-indigo-600' : 'text-slate-600 dark:text-slate-400 group-hover:text-indigo-600' }}" aria-hidden="true"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    d="M5 12a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1M5 12h14M5 12a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1m-2 3h.01M14 15h.01M17 9h.01M14 9h.01" />
            </svg>
        </div>
        <div>
            <div
                class="font-bold text-xxs xs:text-xs sm:text-base {{ request()->routeIs('company') ? 'text-slate-900 dark:text-slate-100' : 'text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-100' }}">
                {{ __('Advertisements') }}
            </div>
            <p
                class="hidden sm:block mt-1 text-sm {{ request()->routeIs('company') ? 'text-slate-700 dark:text-slate-300' : 'text-slate-500 group-hover:text-slate-700 dark:group-hover:text-slate-300' }}">
                {{ __('Current price') }}</p>
        </div>
    </a>
    <a href="{{ $user->company ? route('company.about', ['user' => $user->url_name]) : '#' }}"
        class="group relative flex flex-col sm:flex-row items-center gap-2 sm:gap-4 rounded-lg{{ !$user->company ? ' opacity-60' : '' }}">
        <div
            class="flex h-9 sm:h-11 w-9 sm:w-11 flex-none items-center justify-center rounded-lg bg-slate-50 dark:bg-slate-950">
            <svg class="h-5 sm:h-6 w-5 sm:w-6 {{ request()->routeIs('company.about') ? 'text-indigo-600' : 'text-slate-600 dark:text-slate-400 group-hover:text-indigo-600' }}" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7.864 4.243A7.5 7.5 0 0119.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 004.5 10.5a7.464 7.464 0 01-1.15 3.993m1.989 3.559A11.209 11.209 0 008.25 10.5a3.75 3.75 0 117.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 01-3.6 9.75m6.633-4.596a18.666 18.666 0 01-2.485 5.33" />
            </svg>
        </div>
        <div>
            <div
                class="font-bold text-xxs xs:text-xs sm:text-base {{ request()->routeIs('company.about') ? 'text-slate-900 dark:text-slate-100' : 'text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-100' }}">
                {{ __('About company') }}
            </div>
            <p
                class="hidden sm:block mt-1 text-sm {{ request()->routeIs('company.about') ? 'text-slate-700 dark:text-slate-300' : 'text-slate-500 group-hover:text-slate-700 dark:group-hover:text-slate-300' }}">
                {{ __('Information and documents') }}</p>
        </div>
    </a>
    <a href="{{ $user->hosting && !$user->hosting->moderation ? route('company.hosting', ['user' => $user->url_name]) : '#' }}"
        class="group relative flex flex-col sm:flex-row items-center gap-2 sm:gap-4 rounded-lg{{ !$user->hosting || $user->hosting->moderation ? ' opacity-50' : '' }}">
        <div
            class="flex h-9 sm:h-11 w-9 sm:w-11 flex-none items-center justify-center rounded-lg bg-slate-50 dark:bg-slate-950">
            <svg class="h-5 sm:h-6 w-5 sm:w-6 {{ $user->hosting && !$user->hosting->moderation ? request()->routeIs('company.hosting') ? 'text-indigo-600' : 'text-slate-600 dark:text-slate-400 group-hover:text-indigo-600' : 'text-slate-600 dark:text-slate-400' }}" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
            </svg>
        </div>
        <div>
            <div
                class="font-bold text-xxs xs:text-xs sm:text-base {{ $user->hosting && !$user->hosting->moderation ? request()->routeIs('company.hosting') ? 'text-slate-900 dark:text-slate-100' : 'text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-100' : 'text-slate-600 dark:text-slate-400' }}">
                {{ __('Hosting') }}
            </div>
            <p
                class="hidden sm:block mt-1 text-sm {{ $user->hosting && !$user->hosting->moderation ? request()->routeIs('company.hosting') ? 'text-slate-700 dark:text-slate-300' : 'text-slate-500 group-hover:text-slate-700 dark:group-hover:text-slate-300' : 'text-slate-500' }}">
                {{ __('Placement data') }}
            </p>
        </div>
    </a>
    <a href="{{ route('company.offices', ['user' => $user->url_name]) }}"
        class="group relative flex flex-col sm:flex-row items-center gap-2 sm:gap-4 rounded-lg">
        <div
            class="flex h-9 sm:h-11 w-9 sm:w-11 flex-none items-center justify-center rounded-lg bg-slate-50 dark:bg-slate-950">
            <svg class="h-5 sm:h-6 w-5 sm:w-6 {{ request()->routeIs('company.offices') ? 'text-indigo-600' : 'text-slate-600 dark:text-slate-400 group-hover:text-indigo-600' }}" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z" />
            </svg>
        </div>
        <div>
            <div
                class="font-bold text-xxs xs:text-xs sm:text-base {{ request()->routeIs('company.offices') ? 'text-slate-900 dark:text-slate-100' : 'text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-100' }}">
                {{ __('Offices') }}
            </div>
            <p
                class="hidden sm:block mt-1 text-sm {{ request()->routeIs('company.offices') ? 'text-slate-700 dark:text-slate-300' : 'text-slate-500 group-hover:text-slate-700 dark:group-hover:text-slate-300' }}">
                {{ __('Offices and points of sale') }}
            </p>
        </div>
    </a>
</div>
