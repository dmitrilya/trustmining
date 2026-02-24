<div
    class="p-2 sm:p-4 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow shadow-logo-color rounded-xl">
    <h2 class="mb-2 sm:mb-3 lg:mb-6 text-base text-gray-700 dark:text-gray-300 font-bold">
        {{ __('Advertisements') }}
    </h2>

    <div class="space-y-2">
        <a href="{{ route('ads', ['adCategory' => 'miners']) }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.miner', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Miners') }}</h4>
        </a>
        <a href="{{ route('hostings') }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.hosting', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Hostings') }}</h4>
        </a>
        <a href="{{ route('services') }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.service', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Services') }}</h4>
        </a>
        <a href="{{ route('ads', ['adCategory' => 'legals']) }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.legal', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Legals') }}</h4>
        </a>
        <a href="{{ route('ads', ['adCategory' => 'containers']) }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.container', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Containers') }}</h4>
        </a>
        <a href="{{ route('ads', ['adCategory' => 'noiseboxes']) }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.noisebox', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Noiseboxes') }}</h4>
        </a>
        <a href="{{ route('ads', ['adCategory' => 'cryptoboilers']) }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.cryptoboiler', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Cryptoboilers') }}</h4>
        </a>
        <a href="{{ route('ads', ['adCategory' => 'water_cooling_plates']) }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.water_cooling_plate', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Water cooling plates') }}</h4>
        </a>
        <a href="{{ route('ads', ['adCategory' => 'gpus']) }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.gpu', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('GPU') }}</h4>
        </a>
        <a href="{{ route('ads', ['adCategory' => 'firmwares']) }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.firmware', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Firmwares') }}</h4>
        </a>
        <a href="{{ route('ads', ['adCategory' => 'monitorings']) }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.monitoring', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Monitoring') }}</h4>
        </a>
        <a href="{{ route('cryptoexchangers') }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.cryptoexchanger', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Exchangers') }}</h4>
        </a>
        <a href="{{ route('ads', ['adCategory' => 'accessories']) }}" class="flex items-center group">
            <div
                class="mr-4 size-6 rounded-full group-hover:shadow-lg shadow-logo-color flex items-center justify-center">
                @include('layouts.components.svg.accessories', [
                    'class' =>
                        'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                    'w' => '100%',
                ])
            </div>
            <h4
                class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                {{ __('Accessories') }}</h4>
        </a>
    </div>
</div>
