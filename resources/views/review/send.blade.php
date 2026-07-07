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

            <div class="w-full border border-slate-300 rounded-xl bg-slate-50 dark:bg-slate-900 dark:border-slate-800">
                <div class="px-4 py-2 bg-white rounded-t-xl dark:bg-slate-950">
                    <label for="review" class="sr-only">Your review</label>
                    <textarea id="review" rows="4" x-ref="review" name="review"
                        class="resize-none w-full px-0 text-sm text-slate-800 bg-white border-0 dark:bg-slate-950 focus:ring-0 dark:text-slate-200 dark:placeholder-slate-400"
                        placeholder="{{ __('Each review undergoes strict moderation. Attached documents and photos will not be published, but are needed only to speed up the verification...') }}"
                        required></textarea>
                </div>
                <div class="flex items-center justify-between p-2 border-t dark:border-slate-700">
                    <div class="flex ps-0 space-x-1">
                        <label for="input-document-review" :class="document ? 'text-indigo-500' : 'text-slate-500'"
                            class="inline-flex justify-center items-center p-1 xs:p-2 rounded-md cursor-pointer hover:text-slate-800 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-700">
                            <input id="input-document-review" name="document" class="hidden" type="file"
                                accept=".pdf,.doc,.docx" @change="document = true">
                            <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 12 20">
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                    d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6" />
                            </svg>
                            <span class="sr-only">Attach document</span>
                        </label>

                        <label for="input-image-review" :class="image ? 'text-indigo-500' : 'text-slate-500'"
                            class="inline-flex justify-center items-center p-1 xs:p-2 text-slate-600 rounded-md cursor-pointer hover:text-slate-800 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-700">
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

                        <div class="flex flex-col justify-center ml-2">
                            <div class="text-xxs sm:text-xs text-slate-500" style="display: hidden" x-show="document">
                                {{ __('File') }}: <span class="text-slate-600 dark:text-slate-400">1</span>
                            </div>
                            <div class="text-xxs sm:text-xs text-slate-500" style="display: hidden" x-show="image">
                                {{ __('Photo') }}: <span class="text-slate-600 dark:text-slate-400">1</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="inline-flex items-center p-1.5 xs:py-2.5 xs:px-4 text-xs text-center text-white bg-indigo-600 rounded-full xs:rounded-lg focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-700 hover:bg-indigo-700">
                        <span class="hidden xs:block">{{ __('Send') }}</span>
                        <span class="xs:hidden">
                            <svg xmlns="http://w3.org" viewBox="0 0 24 24" width="18" height="18" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="19" x2="12" y2="5"></line>
                                <polyline points="5 12 12 5 19 12"></polyline>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </form>
        <div class="w-full border border-slate-300 rounded-b-lg dark:border-slate-700 flex items-center justify-center"
            style="height: 172.7px;display:none">
            <p class="text-xl font-semibold text-slate-800 dark:text-slate-200 text-center">
                {{ __('Sent for moderation') }}</p>
        </div>
    @endif
@else
    <div class="flex flex-col items-center justify-center py-6">
        <p class="text-slate-500 text-sm mb-4">
            {{ __('You must be logged in to leave a review.') }}</p>

        <a href="{{ route('login') }}"><x-primary-button>{{ __('Sign in') }}</x-primary-button></a>
    </div>
@endauth
