<footer class="bg-white dark:bg-zinc-900 border-b border-gray-100 dark:border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-6 sm:py-8 lg:py-10 space-y-6 lg:space-y-8">
        <a href="{{ route('home') }}">
            <x-application-logo class="max-h-11" />
        </a>

        <div class="flex cursor-pointer my-2 sm:my-3">
            <button aria-label="{{ __('Change theme to light') }}"
                :class="{
                    'bg-primary-gradient text-white': theme == 'light',
                    'bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-zinc-950 dark:hover:bg-zinc-900 dark:text-gray-100': theme !=
                        'light'
                }"
                class="p-1.5 rounded-l border border-r-0 border-gray-300 dark:border-zinc-700 text-xxs font-semibold"
                @click="if (theme != 'light') {
                    theme = 'light';
                    axios.get('{{ route('change-theme', ['theme' => 'light']) }}');
                    document.body.classList.add('light');
                    document.body.classList.remove('dark');
                }">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 5V3m0 18v-2M7.05 7.05 5.636 5.636m12.728 12.728L16.95 16.95M5 12H3m18 0h-2M7.05 16.95l-1.414 1.414M18.364 5.636 16.95 7.05M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" />
                </svg>
            </button>
            <button aria-label="{{ __('Change theme to dark') }}"
                :class="{
                    'bg-primary-gradient text-white': theme == 'dark',
                    'bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-zinc-950 dark:hover:bg-zinc-900 dark:text-gray-100': theme !=
                        'dark'
                }"
                class="p-1.5 rounded-r border border-l-0 border-gray-300 dark:border-zinc-700 text-xxs font-semibold"
                @click="if (theme != 'dark') {
                    theme = 'dark';
                    axios.get('{{ route('change-theme', ['theme' => 'dark']) }}');
                    document.body.classList.add('dark');
                    document.body.classList.remove('light');
                }">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 21a9 9 0 0 1-.5-17.986V3c-.354.966-.5 1.911-.5 3a9 9 0 0 0 9 9c.239 0 .254.018.488 0A9.004 9.004 0 0 1 12 21Z" />
                </svg>
            </button>
        </div>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            <div class="space-y-2">
                <div class="text-sm text-gray-500 dark:text-gray-500 font-semibold">{{ __('To the buyer') }}</div>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('companies') }}">{{ __('Companies') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('ads', ['adCategory' => 'miners']) }}">{{ __('Miners') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('hostings') }}">{{ __('Hostings') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('services') }}">{{ __('Services') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('ads', ['adCategory' => 'legals']) }}">{{ __('Legals') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('ads', ['adCategory' => 'containers']) }}">{{ __('Containers') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('ads', ['adCategory' => 'noiseboxes']) }}">{{ __('Noiseboxes') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('ads', ['adCategory' => 'cryptoboilers']) }}">{{ __('Cryptoboilers') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('ads', ['adCategory' => 'water_cooling_plates']) }}">{{ __('Water cooling plates') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('cryptoexchangers') }}">{{ __('Cryptoexchangers') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('ads', ['adCategory' => 'accessories']) }}">{{ __('Accessories') }}</a>
            </div>

            <div class="space-y-2">
                <div class="text-sm text-gray-500 dark:text-gray-500 font-semibold">{{ __('To the seller') }}</div>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('support', ['chat' => 1]) }}">{{ __('Write to support') }}</a>
                {{-- <a class="w-max under text-sm text-gray-900 dark:text-gray-50" href="{{ route('roadmap') }}">Roadmap</a> --}}
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('tariffs') }}">{{ __('Tariffs') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50" href="{{ route('support') }}">FAQ</a>
            </div>

            <div class="space-y-2">
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('database') }}">{{ __('Catalog of models') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('calculator') }}">{{ __('Mining calculator') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('warranty') }}">{{ __('Check warranty') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('metrics') }}">{{ __('Metrics') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('articles') }}">{{ __('Blog') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('guides') }}">{{ __('Guides') }}</a>
                {{-- <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('career') }}">{{ __('Career in TrustMining') }}</a> --}}
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('document', ['path' => 'documents/privacy.pdf']) }}">{{ __('Privacy Policy') }}</a>
                <a class="w-max under text-sm text-gray-900 dark:text-gray-50"
                    href="{{ route('document', ['path' => 'documents/agreement.pdf']) }}">{{ __('User Agreement') }}</a>
            </div>
        </div>

        <div>
            <div class="text-sm text-gray-600">ИП Дмитриева Елизавета Николаевна</div>
            <div class="text-sm text-gray-600">ОГРНИП: 325385000082654</div>
        </div>
        <div class="text-xs text-gray-500" style ="max-width: 1312px;">© 2025 - {{ Carbon\Carbon::now()->year }}.
            {{ __('This is not a public offer.') }}</div>
    </div>
</footer>
