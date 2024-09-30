<footer class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-6 sm:py-8 lg:py-10 space-y-4 md:space-y-6 lg:space-y-8">
        <a href="{{ route('home') }}">
            <x-application-logo class="block h-16 w-auto fill-current drop-shadow-sm" />
        </a>

        <div class="grid grid-cols-1 sm:grid-cols-2">
            <div class="space-y-2 mb-4 sm:mb-0">
                <a class="w-max under text-sm text-gray-800 font-semibold" href="{{ route('about') }}">{{ __('About') }}</a>
                <a class="w-max under text-sm text-gray-800 font-semibold" href="{{ route('support') }}">{{ __('Support') }}</a>
                <a class="w-max under text-sm text-gray-800 font-semibold"
                    href="{{ route('articles') }}">{{ __('Blog') }}</a>
                <a class="w-max under text-sm text-gray-800 font-semibold"
                    href="{{ route('career') }}">{{ __('Career in MPlace') }}</a>
                <a class="w-max under text-sm text-gray-800 font-semibold"
                    href="{{ route('document', ['path' => 'documents/privacy.pdf']) }}">{{ __('Privacy') }}</a>
            </div>

            <div class="space-y-2">
                <a class="w-max under text-sm text-gray-800 font-semibold"
                    href="{{ route('ads') }}">{{ __('Miners') }}</a>
                <a class="w-max under text-sm text-gray-800 font-semibold"
                    href="{{ route('hostings') }}">{{ __('Hostings') }}</a>
                <a class="w-max under text-sm text-gray-800 font-semibold"
                    href="{{ route('database') }}">{{ __('Catalog of models') }}</a>
            </div>
        </div>

        <div class="g-col-12 d-lg-none">
            <div class="text-sm text-gray-500">ИП Кононенко Дмитрий Игоревич</div>
            <div class="text-sm text-gray-500">ОГРНИП: 324385000097102</div>
        </div>
        <div class="text-xs text-gray-400" style ="max-width: 1312px;">© 2024 - {{ Carbon\Carbon::now()->year }}. Не
            является
            публичной офертой.</div>
    </div>
</footer>
