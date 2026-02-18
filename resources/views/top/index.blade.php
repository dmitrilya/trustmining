<x-app-layout title="Топ надёжных продавцов оборудования для майнинга — проверенные компании | TrustMining"
    description="Рейтинг проверенных продавцов майнинг-оборудования и услуг. Надёжные магазины, хостинги и поставщики с высоким Trust Factor. Попадите в топ продавцов на TrustMining">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Top reliable companies') }}
        </h1>
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8 space-y-8 lg:space-y-12">
        <div class="max-w-sm md:max-w-4xl mx-auto mt-4 md:mt-8">
            <p class="text-center text-xs sm:text-lg lg:text-xl text-gray-500">
                {{ __('Getting into the Top trusted sellers of TrustMining is not an advertisement, but the result of a comprehensive assessment. We analyze reputation of the seller, transparency of activities, ad history and customer feedback') }}
            </p>
        </div>
    </div>

    <div class="max-w-xl mx-auto px-2 sm:px-6 lg:px-8 py-8 space-y-4 sm:space-y-6">
        @foreach ($users as $user)
            <div class="bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 rounded-xl shadow-lg shadow-logo-color p-2 sm:p-4 lg:p-6 relative">
                @if ($loop->index == 0)
                    <div class="absolute left-1 sm:left-1.5 lg:left-2 top-1.5 sm:top-2 lg:top-3 size-6 sm:size-7 lg:size-8">
                        <img src="/img/gold.webp" alt="gold medal">
                    </div>
                @elseif ($loop->index == 1)
                    <div class="absolute left-1 sm:left-1.5 lg:left-2 top-1.5 sm:top-2 lg:top-3 size-6 sm:size-7 lg:size-8">
                        <img src="/img/silver.webp" alt="silver medal">
                    </div>
                @elseif ($loop->index == 2)
                    <div class="absolute left-1 sm:left-1.5 lg:left-2 top-1.5 sm:top-2 lg:top-3 size-6 sm:size-7 lg:size-8">
                        <img src="/img/bronze.webp" alt="bronze medal">
                    </div>
                @endif

                @include('components.about-seller')

                <a href="{{ route('company', ['user' => $user->url_name]) }}" class="block w-fit ml-auto mt-2 sm:mt-4">
                    <x-primary-button>{{ __('Visit the store') }}</x-primary-button>
                </a>
            </div>
        @endforeach
    </div>
</x-app-layout>
