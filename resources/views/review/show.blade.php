<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ml-3">
                {{ $review->id }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('moderation.components.buttons')

        <div class="w-full bg-white shadow-sm rounded-lg lg:rounded-l-none flex flex-col p-1 sm:p-4">
            <div class="bg-gray-100 p-1 rounded-t-md min-h-72">
                <div class="bg-gray-100 p-1 sm:p-5 h-full space-y-8 duration-100">
                    <div class="flex flex-col w-full leading-1.5 p-4 md-p-6 border-gray-200 bg-white rounded-lg">
                        <div class="flex justify-between mb-3">
                            <div class="text-md font-semibold text-gray-900">
                                {{ $review->user->name }}
                            </div>

                            <span class="date-transform text-xs font-normal text-gray-500"
                                data-date="{{ $review->created_at }}"></span>
                        </div>

                        <div x-data="{ momentRating: {{ $review->rating }} }"><x-rating></x-rating></div>

                        <div class="flex justify-between mt-6">
                            <p class="text-sm font-normal text-gray-500 whitespace-pre-line">
                                {{ $review->review }}</p>

                            <p class="text-sm text-red-600 font-semibold">
                                {{ __('Is under moderation') }}
                            </p>
                        </div>
                    </div>

                    @if ($review->image)
                        <img class="mx-auto min-w-64" src="{{ Storage::disk('private')->temporaryUrl($review->image, now()->addSeconds(2)) }}"
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
