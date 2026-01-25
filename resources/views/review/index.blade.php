@php
    if ($type == 'App\Models\User\User') {
        $user = App\Models\User\User::find($id);
        $href = route('company', ['user' => $user->url_name]);
    } elseif ($type == 'App\Models\Database\AsicModel') {
        $model = App\Models\Database\AsicModel::find($id);
        $href = route('database.model', [
            'asicBrand' => strtolower(str_replace(' ', '_', $model->asicBrand->name)),
            'asicModel' => strtolower(str_replace(' ', '_', $model->name)),
        ]);
    } else {
        $href = '#';
    }
@endphp

<x-app-layout
    title="Отзывы о {{ $type == 'App\Models\User\User' ? 'компании ' . $user->name : 'ASIC майнере ' . $model->asicBrand->name . ' ' . $model->name }}">
    <x-slot name="header">
        <div class="flex items-center">
            @php
                if ($type == 'App\Models\User\User') {
                    $href = route('company', ['user' => App\Models\User\User::find($id)->url_name]);
                } elseif ($type == 'App\Models\Database\AsicModel') {
                    $model = App\Models\Database\AsicModel::find($id);
                    $href = route('database.model', [
                        'asicBrand' => strtolower(str_replace(' ', '_', $model->asicBrand->name)),
                        'asicModel' => strtolower(str_replace(' ', '_', $model->name)),
                    ]);
                } else {
                    $href = '#';
                }
            @endphp

            <x-back-link :href="$href"></x-back-link>

            <h1 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight ml-3">
                {{ __('Reviews') }} {{ $name }}
            </h1>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="w-full bg-white dark:bg-zinc-900 shadow-sm dark:shadow-zinc-800 rounded-lg flex flex-col p-1 sm:p-4">
            <div class="bg-gray-100 dark:bg-zinc-950 p-1 rounded-t-md min-h-72">
                <div class="bg-gray-100 dark:bg-zinc-950 p-1 sm:p-5 h-full space-y-8 duration-100">
                    @foreach ($reviews as $review)
                        @continue ($review->moderation && (!$auth || $review->user->id != $auth->id))

                        <div class="flex w-full">
                            <div class="flex flex-col w-full leading-1.5 p-4 md-p-6 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-990 rounded-lg">
                                <div class="flex justify-between mb-3">
                                    <div class="text-base font-semibold text-gray-950 dark:text-gray-50">
                                        {{ $review->user->name }}
                                    </div>

                                    <span class="date-transform text-xs text-gray-600"
                                        data-date="{{ $review->created_at }}"></span>
                                </div>

                                <div x-data="{ momentRating: {{ $review->rating }} }"><x-rating></x-rating></div>

                                @if ($review->moderation)
                                    <p class="text-sm text-red-600 font-semibold mt-3">{{ __('Is under moderation') }}
                                    </p>
                                @endif

                                <p class="text-sm text-gray-600 whitespace-pre-line mt-3 md:mt-4">
                                    {{ $review->review }}</p>
                            </div>

                            @if ($auth && ($auth->id == $review->reviewable->id || $review->user->id == $auth->id))
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button type="button"
                                            class="ml-4 inline-flex self-center items-center p-2 text-sm text-center text-gray-950 dark:text-gray-50 bg-white rounded-lg hover:bg-gray-200 focus:ring-2 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-zinc-950 dark:hover:bg-zinc-900 dark:focus:ring-zinc-700">
                                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" aria-hidden="true"
                                                fill="currentColor" viewBox="0 0 4 15">
                                                <path
                                                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        @if ($auth->id == $review->reviewable->id)
                                            <x-dropdown-link
                                                href="{{ route('support', ['tab' => 'chat', 'message' => __('Good day! I am writing to appeal review number') . ' ' . $review->id]) }}">{{ __('Complain') }}</x-dropdown-link>
                                        @else
                                            <x-dropdown-link href="#"
                                                @click.prevent="$dispatch('open-modal', 'confirm-review-deletion-{{ $review->id }}')">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        @endif
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>

                        <x-modal name="{{ 'confirm-review-deletion-' . $review->id }}">
                            <form method="post" action="{{ route('review.destroy', ['review' => $review->id]) }}"
                                class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg text-gray-950 dark:text-gray-50">
                                    {{ __('Are you sure you want to delete this review?') }}
                                </h2>

                                <div class="mt-8 flex justify-center">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ml-3">
                                        {{ __('Confirm') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    @endforeach
                </div>
            </div>

            @auth
                @if ($auth->id != $id && !$reviews->where('user_id', $auth->id)->count())
                    <form x-data="{
                        rating: null,
                        momentRating: 0,
                        setRating(r) {
                            this.rating = r;
                            this.momentRating = r
                        },
                        setMomentRating(r) { this.momentRating = r },
                        resetMomentRating() { this.momentRating = this.rating },
                        document: false,
                        image: false
                    }" @submit.prevent="sendReview($el)">
                        @csrf

                        <input type="hidden" name="reviewable_type" value="{{ $type }}">
                        <input type="hidden" name="reviewable_id" value="{{ $id }}">

                        <div
                            class="w-full border border-gray-200 rounded-b-lg bg-gray-50 dark:bg-zinc-900 dark:border-zinc-800">
                            <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-zinc-950">
                                <label for="review" class="sr-only">Your review</label>
                                <textarea id="review" rows="4" x-ref="review" name="review"
                                    class="resize-none w-full px-0 text-sm text-gray-950 bg-white border-0 dark:bg-zinc-950 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                    placeholder="{{ __('Each review undergoes strict moderation. Attached documents and photos will not be published, but are needed only to speed up the verification...') }}"
                                    required></textarea>
                            </div>
                            <div class="flex items-center justify-between px-3 py-2 border-t dark:border-zinc-700">
                                <div class="flex ps-0 space-x-1 rtl:space-x-reverse">
                                    <label for="input-document-review"
                                        :class="document ? 'text-indigo-600' : 'text-gray-500'"
                                        class="inline-flex justify-center items-center p-2 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-zinc-700">
                                        <input id="input-document-review" name="document" class="hidden" type="file"
                                            accept=".pdf,.doc,.docx" @change="document = true">
                                        <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 12 20">
                                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                                d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6" />
                                        </svg>
                                        <span class="sr-only">Attach document</span>
                                    </label>

                                    <label for="input-image-review" :class="image ? 'text-indigo-600' : 'text-gray-500'"
                                        class="inline-flex justify-center items-center p-2 text-gray-600 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-zinc-700">
                                        <input id="input-image-review" name="image" class="hidden" type="file"
                                            accept=".png,.jpg,.jpeg,.webp" @change="image = true">
                                        <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 18">
                                            <path
                                                d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
                                        </svg>
                                        <span class="sr-only duration-300">Upload image</span>
                                    </label>

                                    <input type="hidden" name="rating" :value="rating" required>

                                    <x-rating :clickable="true"></x-rating>
                                </div>
                                <button type="submit"
                                    class="inline-flex items-center py-2.5 px-4 text-xs text-center text-white bg-indigo-600 rounded-lg focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-700 hover:bg-indigo-700">
                                    {{ __('Send') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="w-full border border-gray-200 rounded-b-lg bg-white dark:bg-zinc-800 dark:border-zinc-700 flex items-center justify-center"
                        style="height: 172.7px;display:none">
                        <p class="text-xl font-semibold text-gray-950 dark:text-gray-50 text-center">{{ __('Sent for moderation') }}</p>
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center justify-center py-6">
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">{{ __('You must be logged in to leave a review.') }}</p>

                    <a href="{{ route('login') }}"><x-primary-button>{{ __('Sign in') }}</x-primary-button></a>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>
