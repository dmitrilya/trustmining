<x-app-layout :title="__('meta.rating.companies.title')" :description="__('meta.rating.companies.description')">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('meta.rating.companies.header') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-4 lg:p-6 space-y-2 sm:space-y-4">
        <x-breadcrumbs.breadcrumbs>
            <x-breadcrumbs.breadcrumb position="1" :href="route('ratings')" :name="__('meta.rating.breadcrumb')" />
            <x-breadcrumbs.breadcrumb position="2" :name="__('meta.rating.companies.breadcrumb')" />
        </x-breadcrumbs.breadcrumbs>

        <div class="max-w-4xl mx-auto py-4">
            <p class="text-center text-xs sm:text-lg lg:text-xl text-slate-500">
                {{ __('Getting into the Top trusted sellers of TrustMining is not an advertisement, but the result of a comprehensive assessment. We analyze reputation of the seller, transparency of activities, ad history and customer feedback') }}
            </p>
        </div>

        @foreach ($users as $user)
            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-xl shadow-lg shadow-logo-color p-2 sm:p-4 lg:p-6 relative">
                @if ($loop->index == 0)
                    <div class="absolute left-1 sm:left-1.5 lg:left-2 top-1.5 sm:top-2 lg:top-3 w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8">
                        <img src="/img/gold.webp" alt="gold medal">
                    </div>
                @elseif ($loop->index == 1)
                    <div class="absolute left-1 sm:left-1.5 lg:left-2 top-1.5 sm:top-2 lg:top-3 w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8">
                        <img src="/img/silver.webp" alt="silver medal">
                    </div>
                @elseif ($loop->index == 2)
                    <div class="absolute left-1 sm:left-1.5 lg:left-2 top-1.5 sm:top-2 lg:top-3 w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8">
                        <img src="/img/bronze.webp" alt="bronze medal">
                    </div>
                @endif

                @include('components.about-seller')

                <a href="{{ route('company', ['user' => $user->slug]) }}" class="block w-fit ml-auto mt-2 sm:mt-4">
                    <x-buttons.primary-button>{{ __('Visit the store') }}</x-buttons.primary-button>
                </a>
            </div>
        @endforeach
    </div>
</x-app-layout>
