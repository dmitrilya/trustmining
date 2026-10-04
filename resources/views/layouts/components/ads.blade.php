<div class="{{ $relative ?? false ? 'relative ' : '' }}flex items-center h-full focus:outline-none transition duration-100 ease-in-out" x-data="{ open: false, opened: false }"
    @if (!isset($relative) || !$relative) @mouseover="opened = true; open = true" @mouseleave="open = false" @endif>
    <button class="{{ $classes }}" @click.stop="opened = true; open = ! open">
        <div>{{ __('Advertisements') }}</div>

        <div class="ml-1">
            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    </button>

    <template x-if="opened">
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="transform opacity-0 scale-50"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-50"
            class="w-full absolute z-50 bg-slate-100/95 dark:bg-slate-900/95 rounded-b-2xl shadow-lg shadow-logo-color origin-top left-0 top-0 mt-10 lg:mt-14"
            @click.away="open = false">
            <div class="ring-b-1 ring-slate-300 dark:ring-slate-700 p-4 lg:p-10 xl:p-14">
                <div class="grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 sm:gap-4">
                    @php
                        $categories = [
                            ['n' => 'Miners', 'r' => route('ads', ['adCategory' => 'miners'])],
                            ['n' => 'Hostings', 'r' => route('hostings')],
                            ['n' => 'Services', 'r' => route('services')],
                            ['n' => 'Legals', 'r' => route('ads', ['adCategory' => 'legals'])],
                            ['n' => 'Containers', 'r' => route('ads', ['adCategory' => 'containers'])],
                            ['n' => 'Noiseboxes', 'r' => route('ads', ['adCategory' => 'noiseboxes'])],
                            ['n' => 'Cryptoboilers', 'r' => route('ads', ['adCategory' => 'cryptoboilers'])],
                            ['n' => 'Water cooling plates', 'r' => route('ads', ['adCategory' => 'water_cooling_plates'])],
                            ['n' => 'GPU', 'r' => route('ads', ['adCategory' => 'gpus'])],
                            ['n' => 'Firmwares', 'r' => route('ads', ['adCategory' => 'firmwares'])],
                            ['n' => 'Monitoring', 'r' => route('ads', ['adCategory' => 'monitorings'])],
                            ['n' => 'Exchangers', 'r' => route('cryptoexchangers')],
                            ['n' => 'Accessories', 'r' => route('ads', ['adCategory' => 'accessories'])],
                            ['n' => 'Hydro racks', 'r' => route('ads', ['adCategory' => 'hydro_racks'])],
                        ];
                    @endphp

                    @foreach ($categories as $category)
                        @php
                            $iconName = str_replace(' ', '_', strtolower($category['n']));
                        @endphp

                        <a href="{{ $category['r'] }}"
                            class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm lg:text-base tracking-wide text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 border border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-emerald-500/50 hover:shadow-md shadow-logo-color transition-all duration-150">
                            {{ __($category['n']) }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </template>
</div>
