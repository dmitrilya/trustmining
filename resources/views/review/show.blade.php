<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight ml-3">
                {{ $review->id }}
            </h1>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('moderation.components.buttons')

        <div class="w-full bg-white shadow-sm shadow-logo-color rounded-lg lg:rounded-l-none flex flex-col p-1 sm:p-4">
            <div class="bg-gray-100 p-1 rounded-t-md min-h-72">
                <div class="bg-gray-100 p-1 sm:p-5 h-full space-y-8 duration-100">
                    <div class="flex flex-col w-full leading-1.5 p-4 md-p-6 border-gray-300 bg-white rounded-lg">
                        <div class="flex justify-between mb-3">
                            <div class="text-base font-semibold text-gray-950">
                                {{ $review->user->name }}
                            </div>

                            <span class="date-transform text-xs text-gray-600"
                                data-date="{{ $review->created_at }}"></span>
                        </div>

                        <div x-data="{ momentRating: {{ $review->rating }} }"><x-rating></x-rating></div>

                        @if ($review->moderation)
                            <p class="text-sm text-red-600 font-semibold mt-3">{{ __('Is under moderation') }}</p>
                        @endif

                        <p class="text-sm text-gray-600 whitespace-pre-line mt-3 md:mt-5">
                            {{ $review->review }}</p>
                    </div>

                    @if ($review->image)
                        <img class="mx-auto min-w-64"
                            src="{{ Storage::disk('private')->temporaryUrl($review->image, now()->addSeconds(2)) }}"
                            alt="">
                    @endif

                    @if ($review->document)
                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-8">
                            <x-document :path="$review->document" name="Документ к отзыву" class="bg-white"></x-document>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
