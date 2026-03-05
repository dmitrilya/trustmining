<x-app-layout title="Майнинговая компания {{ $user->name }}: купить ASIC майнер"
    description="Официальный представитель {{ $user->name }}: купите ASIC-майнеры Bitmain, Whatsminer и Canaan с гарантией от производителя. Большой выбор оборудования в наличии, низкие цены, быстрая доставка и профессиональная поддержка 24/7. Проверьте и заберите майнеры в наших офисах или закажите онлайн"
    itemtype="https://schema.org/ProfilePage" :itemname="__('Company') . ' ' . $user->name">
    <x-slot name="og">
        <meta property="og:title" content="{{ $user->company ? __('Company') : __('Seller') }} {{ $user->name }}">
        <meta property="og:description"
            content="Актуальный прайс-лист, информация о дата-центре и данные компании | TRUSTMINING">
        @if ($user->company)
            <meta property="og:image" content="{{ Storage::disk('public')->url($user->company->logo) }}">
        @endif
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8" x-data="{ ad_category_name: null }">
        @if ($user->company)
            @include('shop.components.about')
        @endif

        <div class="flex flex-wrap gap-2 sm:gap-3 mb-4 sm:mb-6">
            @foreach ($ads->pluck('ad_category_header', 'ad_category_name')->unique() as $ad_category_name => $ad_category_header)
                <div @click="ad_category_name = ad_category_name == '{{ $ad_category_name }}' ? null : '{{ $ad_category_name }}'"
                    class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 group border border-slate-400 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700 rounded-md"
                    :class="ad_category_name ==
                        '{{ $ad_category_name }}' ?
                        'border-indigo-500 bg-indigo-200 dark:bg-indigo-600 dark:border-indigo-700' :
                        'border-slate-300 dark:border-slate-700'">
                    <h4 class="font-semibold text-xs lg:text-sm group-hover:text-indigo-500 dark:group-hover:text-slate-100"
                        :class="ad_category_name ==
                            '{{ $ad_category_name }}' ? 'text-indigo-500 dark:text-slate-50' :
                            'text-slate-500 dark:text-slate-300'">
                        {{ __($ad_category_header) }}
                    </h4>
                </div>
            @endforeach
        </div>

        <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @if (auth()->check() && auth()->id() == $user->id)
                <a href="{{ route('ad.create') }}"
                    class="cursor-pointer bg-slate-100 dark:bg-slate-800 group hover:bg-white dark:hover:bg-slate-900 sm:max-w-md p-2 h-full sm:px-4 sm:py-3 shadow-md shadow-logo-color overflow-hidden rounded-lg flex justify-center items-center border-2 border-dashed border-slate-400 dark:border-slate-700">
                    <div class="flex flex-col justify-center items-center">
                        <svg class="w-[72px] h-[72px] text-slate-400 dark:text-slate-300" aria-hidden="true"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2"
                                d="M16.5 15v1.5m0 0V18m0-1.5H15m1.5 0H18M3 9V6a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3M3 9v6a1 1 0 0 0 1 1h5M3 9h16m0 0v1M6 12h3m12 4.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                        </svg>

                        <div
                            class="font-semibold text-xl text-slate-600 dark:text-slate-300 group-hover:text-slate-800 dark:group-hover:text-slate-200 mt-2">
                            {{ __('Create') }}</div>
                    </div>
                </a>
            @endif

            @include('ad.components.list', [
                'owner' => auth()->check() && auth()->id() == $user->id,
                'shop' => true,
            ])

            <div class="mt-8 sm:mt-12 lg:mt-16">
                {{ $ads->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
