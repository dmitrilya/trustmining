<footer class="bg-white dark:bg-zinc-900 border-b border-gray-100 dark:border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-6 sm:py-8 lg:py-10 space-y-6 lg:space-y-8">
        <a href="{{ route('home') }}">
            <x-application-logo class="text-4xl sm:text-6xl" />
        </a>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            <div class="space-y-2">
                <div class="text-sm text-gray-400 dark:text-gray-600 font-semibold">{{ __('To the buyer') }}</div>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('companies') }}">{{ __('Companies') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('ads', ['adCategory' => 'miners']) }}">{{ __('Miners') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('hostings') }}">{{ __('Hostings') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('services') }}">{{ __('Services') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('ads', ['adCategory' => 'legals']) }}">{{ __('Legals') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('ads', ['adCategory' => 'containers']) }}">{{ __('Containers') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('ads', ['adCategory' => 'noiseboxes']) }}">{{ __('Noiseboxes') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('ads', ['adCategory' => 'heat-exchange']) }}">{{ __('Heat exchange') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('cryptoexchangers') }}">{{ __('Cryptoexchangers') }}</a>
            </div>

            <div class="space-y-2">
                <div class="text-sm text-gray-400 dark:text-gray-600 font-semibold">{{ __('To the seller') }}</div>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('support', ['chat' => 1]) }}">{{ __('Write to support') }}</a>
                {{-- <a class="w-max under text-sm text-gray-800 dark:text-gray-100" href="{{ route('roadmap') }}">Roadmap</a> --}}
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('tariffs') }}">{{ __('Tariffs') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100" href="{{ route('support') }}">FAQ</a>
            </div>

            <div class="space-y-2">
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('database') }}">{{ __('Catalog of models') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('calculator') }}">{{ __('Mining calculator') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('warranty') }}">{{ __('Check warranty') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('metrics') }}">{{ __('Metrics') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('articles') }}">{{ __('Blog') }}</a>
                {{-- <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('career') }}">{{ __('Career in TrustMining') }}</a> --}}
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('document', ['path' => 'documents/privacy.pdf']) }}">{{ __('Privacy Policy') }}</a>
                <a class="w-max under text-sm text-gray-800 dark:text-gray-100"
                    href="{{ route('document', ['path' => 'documents/agreement.pdf']) }}">{{ __('User Agreement') }}</a>
            </div>
        </div>

        <div>
            <div class="text-sm text-gray-500">ИП Дмитриева Елизавета Николаевна</div>
            <div class="text-sm text-gray-500">ОГРНИП: 325385000082654</div>
        </div>
        <div class="text-xs text-gray-400" style ="max-width: 1312px;">© 2025 - {{ Carbon\Carbon::now()->year }}.
            {{ __('This is not a public offer.') }}</div>
    </div>
</footer>
