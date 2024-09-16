<h2 class="sr-only">Информация о продавце</h2>

<div class="text-xs text-gray-400">
    {{ $user->company && !$user->company->moderation ? __('Company') : __('Person') }}
</div>

<div class="flex align-center">
    <a href="{{ route('company', ['user' => $user->url_name]) }}"
        class="hover:underline text-sm text-indigo-600 hover:text-indigo-500">{{ $user->name }}</a>
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
