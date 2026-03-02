<div itemprop="seller" itemscope itemtype="https://schema.org/Organization">
    <h2 class="sr-only">Информация о продавце</h2>

    <div class="flex items-center">
        @if (
            $user->company &&
                ($user->company->logo ||
                    (isset($moderation) &&
                        isset($auth) &&
                        in_array($auth->role->name, ['admin', 'moderator']) &&
                        isset($moderation->data['logo']))))
            <img itemprop="logo" class="rounded-full mr-2 {{ isset($bg) ? 'size-12 sm:size-14 lg:size-16' : 'size-12' }}"
                src="{{ Storage::url(isset($moderation->data['logo']) ? $moderation->data['logo'] : $user->company->logo) }}"
                alt="">
        @endif

        <div>
            <div class="text-xs text-slate-500 dark:text-slate-400">
                {{ $user->company && !$user->company->moderation ? __($user->company->card['type']) : __('Person') }}
            </div>

            <meta itemprop="name" content="{{ $user->name }}">
            <a itemprop="url" href="{{ route('company', ['user' => $user->url_name]) }}"
                class="hover:underline text-sm text-indigo-600 hover:text-indigo-500">{{ $user->name }}</a>
        </div>
    </div>

    @include('components.about-seller_tables')

    <div class="mt-4">
        <h3 class="sr-only">{{ __('Reviews') }}</h3>
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
</div>
