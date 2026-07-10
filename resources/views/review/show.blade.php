<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight ml-3">
                {{ $review->id }}
            </h1>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        @include('moderation.components.buttons')

        <div class="w-full bg-white shadow-sm shadow-logo-color rounded-xl lg:rounded-l-none flex flex-col p-1 sm:p-4">
            <div class="bg-slate-100 p-1 rounded-t-md min-h-72">
                <div class="bg-slate-100 p-1 sm:p-5 h-full space-y-8 duration-100">
                    <div class="flex flex-col w-full leading-1.5 p-4 md-p-6 border-slate-300 bg-white rounded-lg">
                        <div class="flex justify-between mb-3">
                            <div class="text-base font-semibold text-slate-800">
                                {{ $review->user->name }}
                            </div>

                            <span class="date-transform text-xs text-slate-500"
                                data-date="{{ $review->moderations()->count() > 1 ? $review->updated_at : $review->created_at }}"></span>
                        </div>

                        <div x-data="{ momentRating: {{ isset($moderation->data['rating']) ? $moderation->data['rating'] : $review->rating }} }"><x-rating></x-rating></div>

                        <p class="text-sm text-slate-600 whitespace-pre-line mt-3 md:mt-5">
                            {{ isset($moderation->data['review']) ? $moderation->data['review'] : $review->review }}</p>
                    </div>

                    @if (isset($moderation->data['image']))
                        <img class="mx-auto min-w-64"
                            src="{{ Storage::disk('private')->temporaryUrl($moderation->data['image'], now()->addSeconds(15)) }}"
                            alt="">
                    @elseif ($review->image)
                        <img class="mx-auto min-w-64"
                            src="{{ Storage::disk('private')->temporaryUrl($review->image, now()->addSeconds(15)) }}"
                            alt="">
                    @endif

                    @if (isset($moderation->data['document']))
                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-8">
                            <x-document :path="Storage::disk('private')->temporaryUrl(
                                $moderation->data['document'],
                                now()->addSeconds(60),
                            )" name="Документ к отзыву" class="bg-white"></x-document>
                        </div>
                    @elseif ($review->document)
                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-8">
                            <x-document :path="Storage::disk('private')->temporaryUrl($review->document, now()->addSeconds(60))" name="Документ к отзыву" class="bg-white"></x-document>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
