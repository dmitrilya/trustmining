<div class="w-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6">
    <ul role="list" class="divide-y divide-gray-200">
        @foreach ($companies as $company)
            <a href="{{ route('company', ['user' => $company->user->url_name]) }}"
                class="rounded-md hover:bg-gray-200 block p-4 flex justify-between">
                <div class="flex min-w-0 gap-x-4 w-full">
                    @if ($company->logo)
                        <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="{{ Storage::url($company->logo) }}"
                            alt="{{ $company->user->url_name }}">
                    @endif
                    
                    <div class="min-w-0 flex-auto mr-6 w-full">
                        <p class="text-sm font-semibold leading-6 text-gray-900">{{ $company->user->name }}</p>

                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $company->name }}</p>
                    </div>
                </div>
                <div class="flex flex-col items-end" x-data="{ momentRating: {{ $company->user->moderatedReviews->count() ? $company->user->moderatedReviews->avg('rating') : 0 }} }">
                    <x-rating></x-rating>

                    <div class="mt-2 text-sm text-indigo-600">
                        {{ $company->user->moderatedReviews->count() }}
                        {{ __('reviews') }}</div>
                </div>
            </a>
        @endforeach
    </ul>
</div>
