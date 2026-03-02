<div class="mt-4 sm:mt-6">
    <div
        class="flex items-center w-fit bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-md shadow-logo-color rounded-xl px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-4">
        <h2 class="font-bold text-lg sm:text-xl text-slate-900 dark:text-slate-100">
            {{ __('Comments') }}
        </h2>

        <p class="ml-1.5 font-bold text-lg sm:text-xl text-slate-900 dark:text-slate-100">
            {{ $comments->count() }}
        </p>
    </div>

    <div class="space-y-4 lg:space-y-6">
        @include('insight.components.comments.send')

        <div id="comments-container" class="space-y-2 lg:space-y-3" data-last-id="{{ $comments->max('id') ?? 0 }}">
            @include('insight.components.comments.comment-list')
        </div>
    </div>
</div>
