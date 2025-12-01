@props(['withoutSort' => false])

<div class="flex items-center">
    @if (!$withoutSort)
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="inline-flex items-center border border-transparent text-sm leading-4 rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-zinc-900 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                    <span class="hidden xs:block">{{ __('Sort') }}</span>
                    <span class="xs:hidden">{{ __('Sort.') }}</span>

                    <div class="ml-1">
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                {{ $sort }}
            </x-slot>
        </x-dropdown>
    @endif

    {{-- <button type="button" class="-m-2 ml-5 p-2 text-gray-400 hover:text-gray-500 sm:ml-7">
      <span class="sr-only">View grid</span>
      <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M4.25 2A2.25 2.25 0 002 4.25v2.5A2.25 2.25 0 004.25 9h2.5A2.25 2.25 0 009 6.75v-2.5A2.25 2.25 0 006.75 2h-2.5zm0 9A2.25 2.25 0 002 13.25v2.5A2.25 2.25 0 004.25 18h2.5A2.25 2.25 0 009 15.75v-2.5A2.25 2.25 0 006.75 11h-2.5zm9-9A2.25 2.25 0 0011 4.25v2.5A2.25 2.25 0 0013.25 9h2.5A2.25 2.25 0 0018 6.75v-2.5A2.25 2.25 0 0015.75 2h-2.5zm0 9A2.25 2.25 0 0011 13.25v2.5A2.25 2.25 0 0013.25 18h2.5A2.25 2.25 0 0018 15.75v-2.5A2.25 2.25 0 0015.75 11h-2.5z" clip-rule="evenodd" />
      </svg>
    </button> --}}

    <button @click="filter = true" type="button" class="-m-2 ml-2 p-2 text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 sm:ml-4">
        <span class="sr-only">Filters</span>
        <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z"
                clip-rule="evenodd" />
        </svg>
    </button>
</div>
