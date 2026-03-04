<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

<div itemprop="mainEntity" itemscope itemtype="https://schema.org/Organization">
    @if ($user->company->banner)
        <img itemprop="image" src="{{ Storage::url($user->company->banner) }}" alt="{{ $user->name }} banner"
            class="w-full aspect-[960/360] rounded-xl mb-4 lg:mb-6">
    @endif

    <div
        class="border border-slate-300 dark:border-slate-700 shadow-md shadow-logo-color rounded-xl p-4 lg:p-6 mb-4 lg:mb-6">
        <div class="flex justify-between items-start mb-1 sm:mb-2">
            <div class="flex items-center">
                @if ($user->company->logo)
                    <img itemprop="logo" class="rounded-full mr-2 sm:mr-3 size-12 sm:size-14 lg:size-16"
                        src="{{ Storage::url($user->company->logo) }}" alt="{{ $user->name }} logo">
                @endif

                <div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        {{ __($user->company->card['type']) }}
                    </div>

                    <h1 itemprop="name"
                        class="mb-1 sm:mb-1.5 text-xs sm:text-sm lg:text-base text-slate-900 dark:text-slate-100 font-bold">
                        {{ $user->name }}</h1>

                    @include('components.about-seller_tables')
                </div>
            </div>

            <div class="flex items-center ml-4">
                <a href="{{ route('chat.start', ['user' => $user->id]) }}" aria-label="Contact" target="_blank">
                    <svg class="size-5 sm:size-6 lg:size-7 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200" aria-hidden="true" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 9h5m3 0h2M7 12h2m3 0h5M5 5h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-6.616a1 1 0 0 0-.67.257l-2.88 2.592A.5.5 0 0 1 8 18.477V17a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                    </svg>
                </a>

                {{-- @if ($user->company->site)
                    <a href="{{ $user->company->site }}" aria-label="Site link" class="ml-2 lg:ml-3">
                        <svg class="size-4 sm:size-5 lg:size-6 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                                d="M4.37 7.657c2.063.528 2.396 2.806 3.202 3.87 1.07 1.413 2.075 1.228 3.192 2.644 1.805 2.289 1.312 5.705 1.312 6.705M20 15h-1a4 4 0 0 0-4 4v1M8.587 3.992c0 .822.112 1.886 1.515 2.58 1.402.693 2.918.351 2.918 2.334 0 .276 0 2.008 1.972 2.008 2.026.031 2.026-1.678 2.026-2.008 0-.65.527-.9 1.177-.9H20M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </a>
                @endif --}}

                <button aria-label="Share"
                    class="ml-2 lg:ml-3 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200"
                    @click="navigator.share({
                            title: '{{ __('Company') . ' ' . $user->name }}',
                            description: 'Актуальный прайс-лист, информация о дата-центре и данные компании | TRUSTMINING',
                            image: '{{ Storage::disk('public')->url($user->company->logo) }}',
                            url: '{{ url()->current() }}' + '?utm_source=share_button&utm_campaign=content_propagation&utm_medium=company&utm_content={{ $user->company->id }}'
                        });">
                    <svg class="size-5 sm:size-6 lg:size-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="m15.141 6 5.518 4.95a1.05 1.05 0 0 1 0 1.549l-5.612 5.088m-6.154-3.214v1.615a.95.95 0 0 0 1.525.845l5.108-4.251a1.1 1.1 0 0 0 0-1.646l-5.108-4.251a.95.95 0 0 0-1.525.846v1.7c-3.312 0-6 2.979-6 6.654v1.329a.7.7 0 0 0 1.344.353 5.174 5.174 0 0 1 4.652-3.191l.004-.003Z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="mt-4">
            <h2 class="sr-only">{{ __('Reviews') }}</h2>
            <div class="flex items-center" x-data="{ momentRating: {{ $user->moderatedReviews->count() ? $user->moderatedReviews->avg('rating') : 0 }} }">
                <x-rating></x-rating>

                <a href="{{ route('company.reviews', ['user' => $user->url_name]) }}"
                    class="ml-3 text-sm text-indigo-600 hover:text-indigo-500">{{ $user->moderatedReviews->count() }}
                    {{ __('reviews') }}</a>
            </div>
        </div>

        <div class="flex items-center mt-2 sm:mt-3">
            <div
                class="trust mr-1 sm:mr-2 size-3 md:size-4 rounded-full border border-slate-300 dark:border-slate-700 {{ $user->tf > config('trustfactor.yellow') ? ($user->tf > config('trustfactor.green') ? 'bg-green-500' : 'bg-yellow-300') : 'bg-red-600' }}">
            </div>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Trust Factor</p>
        </div>

        <div itemprop="description"
            class="ql-editor mt-3 sm:mt-4 lg:mt-5 text-xs sm:text-sm text-slate-600 dark:text-slate-400{{ !request()->routeIs('company.about') ? ' h-16 !overflow-y-hidden line-clamp-4 sm:line-clamp-3' : '' }}">{!! $user->company->description !!}</div>
        
        @if (!request()->routeIs('company.about'))
            <a href="{{ route('company.about', ['user' => $user->url_name]) }}" target="_blank"
                class="mt-2 block w-fit ml-auto text-xs xs:text-sm text-indigo-500 hover:text-indigo-600">{{ __('Read more') }}</a>
        @endif

        @include('shop.components.menu')
    </div>
</div>
