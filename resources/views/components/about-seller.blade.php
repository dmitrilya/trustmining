<h2 class="sr-only">Информация о продавце</h2>

<div class="flex items-center">
    @if (
        $user->company &&
            ($user->company->logo ||
                (isset($moderation) &&
                    isset($auth) &&
                    in_array($auth->role->name, ['admin', 'moderator']) &&
                    isset($moderation->data['logo']))))
        <img class="rounded-full mr-2 w-12 h-12"
            src="{{ Storage::url(isset($moderation->data['logo']) ? $moderation->data['logo'] : $user->company->logo) }}"
            alt="">
    @endif

    <div>
        <div class="text-xs text-gray-400 dark:text-gray-500">
            {{ $user->company && !$user->company->moderation ? __($user->company->card['type']) : __('Person') }}
        </div>

        <a href="{{ route('company', ['user' => $user->url_name]) }}"
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

<div class="mt-2 sm:mt-3">
    <p class="text-xs sm:text-sm text-gray-400 dark:text-gray-500">
        {{ __('Trust Factor') }}: <span class="font-bold {{ $user->tf > 60 ? $user->tf > 80 ? 'text-green-500' : 'text-yellow-300' : 'text-red-600' }}">{{ $user->tf }}</span>
    </p>
</div>
