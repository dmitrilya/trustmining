<div class="space-y-2 sm:space-y-4 duration-100">
    @foreach ($reviews as $review)
        @continue ($review->moderation && (!$auth || $review->user->id != $auth->id))

        <div class="flex w-full">
            <div
                class="flex flex-col w-full leading-1.5 p-2 sm:p-4 border border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 rounded-xl">
                <div class="flex justify-between mb-2">
                    <div class="text-base font-semibold text-slate-900 dark:text-slate-200">
                        {{ $review->user->name }}
                    </div>

                    <span class="date-transform text-xs text-slate-500" data-date="{{ $review->created_at }}"></span>
                </div>

                <div x-data="{ momentRating: {{ $review->rating }} }"><x-rating></x-rating></div>

                @if ($review->moderation)
                    <p class="text-sm text-red-600 font-semibold mt-2">{{ __('Is under moderation') }}
                    </p>
                @endif

                <p class="text-sm text-slate-600 dark:text-slate-400 whitespace-pre-line mt-2 md:mt-3">
                    {{ $review->review }}</p>
            </div>

            @if ($auth && ($auth->id == $review->reviewable->id || $review->user->id == $auth->id))
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button type="button"
                            class="ml-2 sm:ml-3 inline-flex self-center items-center p-2 text-sm text-center rounded-xl text-slate-900 dark:text-slate-50 bg-slate-100 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-950 focus:ring-2 focus:ring-slate-300 dark:focus:ring-slate-700 focus:outline-none">
                            <svg class="w-4 h-4 text-slate-700 dark:text-slate-300" aria-hidden="true"
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
            <form method="post" action="{{ route('review.destroy', ['review' => $review->id]) }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg text-slate-950 dark:text-slate-50">
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
