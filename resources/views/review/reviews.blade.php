<div class="space-y-2 sm:space-y-4 duration-100">
    @foreach ($reviews as $review)
        @php
            $isOwnReview = $auth && $review->user->id == $auth->id;
        @endphp

        @continue ($review->moderation && !$isOwnReview)

        <div class="flex w-full"
            @if ($isOwnReview) x-data="{ 
                isUnderModeration: {{ $review->moderations()->where('moderation_status_id', 1)->exists() ? 'true' : 'false' }},
                isEditing: false,
                rating: {{ $review->rating }},
                momentRating: {{ $review->rating }},
                setRating(r) { this.rating = r; this.momentRating = r; },
                setMomentRating(r) { this.momentRating = r },
                resetMomentRating() { this.momentRating = this.rating },
                document: false,
                image: false,
            }" @endif>
            <div @if ($isOwnReview) x-show="!isEditing" @endif
                class="flex flex-col w-full leading-1.5 p-2 sm:p-4 border border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 rounded-xl">
                <div class="flex justify-between mb-2">
                    <div class="text-base font-semibold text-slate-800 dark:text-slate-200">
                        {{ $review->user->name }}
                    </div>

                    <span class="date-transform text-xs text-slate-500" data-date="{{ $review->moderations()->count() > 1 ? $review->updated_at : $review->created_at }}"></span>
                </div>

                <div x-data="{ momentRating: {{ $review->rating }} }"><x-rating></x-rating></div>

                @if ($isOwnReview)
                    <template x-if="isUnderModeration">
                        <p class="text-sm text-red-600 font-semibold mt-2">{{ __('Is under moderation') }}</p>
                    </template>
                @endif

                <p class="text-sm text-slate-600 dark:text-slate-400 whitespace-pre-line mt-2 md:mt-3">
                    {{ $review->review }}</p>
            </div>

            @if ($isOwnReview)
                <form x-show="isEditing"
                    @submit.prevent="
                    const formData = new FormData($el);
                    formData.append('_method', 'PATCH');
                    
                    axios.post('{{ route('review.update', ['review' => $review->id]) }}', formData)
                        .then(r => {
                            if (r.data.success) {
                                isUnderModeration = true;
                                isEditing = false;
                                pushToastAlert(r.data.message, 'success');
                            } else {
                                pushToastAlert(r.data.message, 'error');
                            }
                        }).catch(e => pushToastAlert(e.response?.data?.message || 'Error', 'error'))"
                    class="w-full border border-slate-300 rounded-xl bg-slate-50 dark:bg-slate-900 dark:border-slate-800"
                    enctype="multipart/form-data">
                    <div class="px-4 py-2 bg-white rounded-t-xl dark:bg-slate-950">
                        <label for="review-{{ $review->id }}" class="sr-only">Your review</label>
                        <textarea id="review-{{ $review->id }}" rows="4" name="review"
                            class="resize-none w-full px-0 text-sm text-slate-800 bg-white border-0 dark:bg-slate-950 focus:ring-0 dark:text-slate-200 dark:placeholder-slate-400"
                            required>{{ $review->review }}</textarea>
                    </div>

                    <div class="flex items-center justify-between p-2 border-t dark:border-slate-700">
                        <div class="flex ps-0 space-x-1 items-center">
                            <label :for="'input-doc-' + {{ $review->id }}"
                                :class="document ? 'text-indigo-500' : 'text-slate-500'"
                                class="inline-flex justify-center items-center p-1 xs:p-2 rounded-md cursor-pointer hover:text-slate-800 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-700">
                                <input :id="'input-doc-' + {{ $review->id }}" name="document" class="hidden"
                                    type="file" accept=".pdf,.doc,.docx" @change="document = true">
                                <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 12 20">
                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                        d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6" />
                                </svg>
                            </label>

                            <label :for="'input-img-' + {{ $review->id }}"
                                :class="image ? 'text-indigo-500' : 'text-slate-500'"
                                class="inline-flex justify-center items-center p-1 xs:p-2 text-slate-600 rounded-md cursor-pointer hover:text-slate-800 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-700">
                                <input :id="'input-img-' + {{ $review->id }}" name="image" class="hidden"
                                    type="file" accept=".png,.jpg,.jpeg,.webp" @change="image = true">
                                <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 18">
                                    <path
                                        d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
                                </svg>
                            </label>

                            <input type="hidden" name="rating" :value="rating" required>

                            <x-rating :clickable="true"></x-rating>

                            <div class="flex flex-col justify-center ml-2">
                                <div class="text-xxs sm:text-xs text-slate-500" x-show="document">
                                    {{ __('File') }}: <span class="text-slate-600 dark:text-slate-400">1</span>
                                </div>
                                <div class="text-xxs sm:text-xs text-slate-500" x-show="image">
                                    {{ __('Photo') }}: <span class="text-slate-600 dark:text-slate-400">1</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <button type="button" @click="isEditing = false"
                                class="xs:px-3 py-1 text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200">
                                <span class="hidden xs:block">{{ __('Cancel') }}</span>
                                <span class="xs:hidden">
                                    <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </span>
                            </button>

                            <button type="submit"
                                class="inline-flex items-center p-1.5 xs:py-2.5 xs:px-4 text-xs text-center text-white bg-indigo-600 rounded-full xs:rounded-lg focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-700 hover:bg-indigo-700">
                                <span class="hidden xs:block">{{ __('Save') }}</span>
                                <span class="xs:hidden">
                                    <svg xmlns="http://w3.org" viewBox="0 0 24 24" width="18" height="18"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <line x1="12" y1="19" x2="12" y2="5"></line>
                                        <polyline points="5 12 12 5 19 12"></polyline>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            @endif

            @if ($auth && (($review->reviewable_type == 'user' && $auth->id == $review->reviewable->id) || $isOwnReview))
                <template x-if="!isEditing">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button type="button"
                                class="ml-2 sm:ml-3 inline-flex self-center items-center p-2 text-sm text-center rounded-xl text-slate-800 dark:text-slate-200 bg-slate-100 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-950 focus:ring-2 focus:ring-slate-300 dark:focus:ring-slate-700 focus:outline-none">
                                <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" aria-hidden="true"
                                    fill="currentColor" viewBox="0 0 4 15">
                                    <path
                                        d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if ($review->reviewable_type == 'user' && $auth->id == $review->reviewable->id)
                                <x-dropdown-link
                                    href="{{ route('support', ['tab' => 'chat', 'message' => __('Good day! I am writing to appeal review number') . ' ' . $review->id]) }}">{{ __('Complain') }}</x-dropdown-link>
                            @else
                                <x-dropdown-link href="#" x-show="!isUnderModeration && !isEditing"
                                    @click.prevent="isEditing = true; image = false; document = false;">
                                    {{ __('Edit') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="#"
                                    @click.prevent="$dispatch('open-modal', 'confirm-review-deletion-{{ $review->id }}')">
                                    {{ __('Delete') }}
                                </x-dropdown-link>
                            @endif
                        </x-slot>
                    </x-dropdown>
                </template>
            @endif
        </div>

        <x-modal name="{{ 'confirm-review-deletion-' . $review->id }}">
            <form method="post" action="{{ route('review.destroy', ['review' => $review->id]) }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg text-slate-800 dark:text-slate-200">
                    {{ __('Are you sure you want to delete this review?') }}
                </h2>

                <div class="mt-8 flex justify-center">
                    <x-buttons.secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-buttons.secondary-button>

                    <x-buttons.danger-button class="ml-3">
                        {{ __('Confirm') }}
                    </x-buttons.danger-button>
                </div>
            </form>
        </x-modal>
    @endforeach
</div>
