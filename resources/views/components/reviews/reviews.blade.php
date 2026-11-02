@props(['user'])

<div class="mt-4">
    <h2 class="sr-only">{{ __('Reviews') }}</h2>
    <div class="flex items-center" x-data="{ momentRating: {{ $user->moderatedReviews->count() ? $user->moderatedReviews->avg('rating') : 0 }} }">
        <x-reviews.rating />

        <a href="{{ route('company.reviews', ['user' => $user->slug]) }}"
            class="ml-3 text-sm text-indigo-500 hover:text-indigo-600">{{ $user->moderatedReviews->count() }}
            {{ trans_choice('navigation.reviews', $user->moderatedReviews->count()) }}</a>
    </div>

    @if (count($externalRatings = $user->getExternalRatings()))
        <div class="mt-2 flex flex-wrap gap-2 sm:gap-3">
            @foreach ($externalRatings as $externalRating)
                <div>
                    <h3 class="sr-only">{{ __('Rating') . ' ' . $externalRating['source_name'] }}</h3>

                    <div class="flex items-center gap-2">
                        <img class="h-8 sm:h-10 lg:h-12 rounded-xl" src="/img/sources/{{ $externalRating['logo'] }}" alt="{{ $externalRating['source_name'] }} logo">
                        <div>
                            <div class="font-mono text-slate-800 dark:text-slate-200 text-xl sm:text-2xl">{{ $externalRating['rating'] }}</div>
                            <div class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm">
                                {{ $externalRating['reviews_count'] . ' ' . trans_choice('navigation.reviews', $externalRating['reviews_count']) }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
