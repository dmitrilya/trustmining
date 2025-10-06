<footer class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-6 sm:py-8 lg:py-10 space-y-6 lg:space-y-8">
        <a href="{{ route('home') }}">
            <x-application-logo class="text-4xl sm:text-6xl" />
        </a>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            <div class="space-y-2">
                <div class="text-sm text-gray-400 font-semibold">{{ __('To the buyer') }}</div>
                <a class="w-max under text-sm text-gray-800" href="{{ route('ads') }}">{{ __('Miners') }}</a>
                <a class="w-max under text-sm text-gray-800" href="{{ route('hostings') }}">{{ __('Hostings') }}</a>
                <a class="w-max under text-sm text-gray-800" href="{{ route('services') }}">{{ __('Services') }}</a>
                <a class="w-max under text-sm text-gray-800" href="{{ route('calculator') }}">{{ __('Mining calculator') }}</a>
                <a class="w-max under text-sm text-gray-800" href="{{ route('metrics') }}">{{ __('Metrics') }}</a>
                <a class="w-max under text-sm text-gray-800" href="{{ route('companies') }}">{{ __('Companies') }}</a>
                <a class="w-max under text-sm text-gray-800"
                    href="{{ route('support', ['chat' => 1]) }}">{{ __('Write to support') }}</a>
            </div>

            <div class="space-y-2">
                <div class="text-sm text-gray-400 font-semibold">{{ __('To the seller') }}</div>
                <a class="w-max under text-sm text-gray-800" href="{{ route('roadmap') }}">Roadmap</a>
                <a class="w-max under text-sm text-gray-800" href="{{ route('tariffs') }}">{{ __('Tariffs') }}</a>
                <a class="w-max under text-sm text-gray-800" href="{{ route('support') }}">FAQ</a>
            </div>

            <div class="space-y-2">
                <a class="w-max under text-sm text-gray-800"
                    href="{{ route('database') }}">{{ __('Catalog of models') }}</a>
                <a class="w-max under text-sm text-gray-800" href="{{ route('articles') }}">{{ __('Blog') }}</a>
                {{-- <a class="w-max under text-sm text-gray-800"
                    href="{{ route('career') }}">{{ __('Career in TrustMining') }}</a> --}}
                <a class="w-max under text-sm text-gray-800"
                    href="{{ route('document', ['path' => 'documents/privacy.pdf']) }}">{{ __('Privacy Policy') }}</a>
                <a class="w-max under text-sm text-gray-800"
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
