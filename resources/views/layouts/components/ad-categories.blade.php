<a href="{{ route('ads', ['adCategory' => 'miners']) }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.miner', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '50%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Miners') }}</h4>
</a>
<a href="{{ route('hostings') }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.hosting', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '60%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Hostings') }}</h4>
</a>
<a href="{{ route('services') }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.service', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '55%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Services') }}</h4>
</a>
<a href="{{ route('ads', ['adCategory' => 'legals']) }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.legal', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '50%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Legals') }}</h4>
</a>
<a href="{{ route('ads', ['adCategory' => 'containers']) }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.container', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '65%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Containers') }}</h4>
</a>
<a href="{{ route('ads', ['adCategory' => 'noiseboxes']) }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.noisebox', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '50%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Noiseboxes') }}</h4>
</a>
<a href="{{ route('ads', ['adCategory' => 'cryptoboilers']) }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.cryptoboiler', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '50%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Cryptoboilers') }}</h4>
</a>
<a href="{{ route('ads', ['adCategory' => 'water_cooling_plates']) }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.water_cooling_plate', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '55%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Water cooling plates') }}</h4>
</a>
{{-- <a href="{{ route('ads', ['adCategory' => 'gpus']) }}"
    class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.gpu', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '70%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('GPU') }}</h4>
</a> --}}
<a href="{{ route('ads', ['adCategory' => 'firmwares']) }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.firmware', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '50%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Firmwares') }}</h4>
</a>
<a href="{{ route('ads', ['adCategory' => 'monitorings']) }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.monitoring', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '50%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Monitoring') }}</h4>
</a>
<a href="{{ route('cryptoexchangers') }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.cryptoexchanger', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '55%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Exchangers') }}</h4>
</a>
<a href="{{ route('ads', ['adCategory' => 'accessories']) }}" class="flex flex-col items-center group">
    <div
        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
        @include('layouts.components.svg.accessories', [
            'class' => 'text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100',
            'w' => '55%',
        ])
    </div>
    <h4
        class="text-xs xs:text-sm lg:text-base text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
        {{ __('Accessories') }}</h4>
</a>
