<x-app-layout>
    <div class="bg-gray-900 h-128 lg:h-144 xl:h-160 relative z-10 overflow-hidden">
        <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8 relative">
            <div class="mt-4 md:mt-6 lg:mt-8 xl:mt-10 py-4 sm:py-6 lg:py-8 mb-4 sm:mb-6 lg:mb-8 text-center">
                <div class="text-white font-semibold text-lg sm:text-xl md:text-3xl lg:text-4xl xl:text-5xl mb-2 sm:mb-4 lg:mb-6">
                    {{ __('Pricing plans for teams of all sizes') }}</div>
                <div class="max-w-3xl mx-auto text-gray-300 sm:text-lg lg:text-xl xl:text-2xl">
                    {{ __('Choose a tariff plan according to your company request. For all questions, please contact support') }}
                </div>
            </div>

            <svg viewBox="0 0 1208 1024" class="absolute -translate-x-1/2 left-1/2 top-1/2 h-[60rem] -z-10"
                style="mask-image: radial-gradient(closest-side, white, transparent)">
                <ellipse cx="604" cy="512" rx="604" ry="512"
                    fill="url(#6d1bd035-0dd1-437e-93fa-59d316231eb0)"></ellipse>
                <defs>
                    <radialGradient id="6d1bd035-0dd1-437e-93fa-59d316231eb0">
                        <stop stop-color="#6366f1"></stop>
                        <stop offset="1" stop-color="#E935C1"></stop>
                    </radialGradient>
                </defs>
            </svg>
        </div>
    </div>

    <div class="bg-gray-100 relative z-20">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 pt-8 pb-16 relative">
            @include('tariff.components.tariffs')
        </div>
    </div>
</x-app-layout>
