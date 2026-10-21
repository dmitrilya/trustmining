<x-app-layout title="{{ __($category->name) }} - {{ __($subcategory->name) }}" :description="__('meta.forum.subcategory.description', ['category' => $category->name, 'subcategory' => $subcategory->name])">
    <x-slot name="header">
        <div class="flex justify-end">
            <a class="mr-1 xs:mr-2" href="{{ route('forum.question.mine') }}">
                <x-buttons.secondary-button class="bg-secondary-gradient dark:text-slate-800">{{ __('My questions') }}</x-buttons.secondary-button>
            </a>
            <a class="" href="{{ route('forum.question.create') }}">
                <x-buttons.primary-button>
                    {{ __('New question') }}
                </x-buttons.primary-button>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <x-breadcrumbs.breadcrumbs>
            <x-breadcrumbs.breadcrumb position="1" :href="route('forum')" :name="__('Forum')" />
            <x-breadcrumbs.breadcrumb position="2" :href="route('forum.category', ['forumCategory' => $category->slug])" :name="__($category->name)" />
            <x-breadcrumbs.breadcrumb position="3" :name="__($subcategory->name)" />
        </x-breadcrumbs.breadcrumbs>

        <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl">
            <h1
                class="mb-1 sm:mb-3 lg:mb-6 p-4 md:p-6 xs:text-lg sm:text-xl lg:text-2xl text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-bold">
                {{ __($subcategory->name) }}
            </h1>

            <div class="divide-y divide-slate-300 dark:divide-slate-700">
                @foreach ($questions as $question)
                    <a class="block"
                        href="{{ route('forum.question.show', [
                            'forumCategory' => $question->forumSubcategory->forumCategory->slug,
                            'forumSubcategory' => $question->forumSubcategory->slug,
                            'forumQuestion' => $question->id . '-' . Str::slug($question->theme),
                        ]) }}">
                        <div class="px-4 py-2 xs:py-3 sm:px-6 group hover:bg-slate-200 dark:hover:bg-slate-950">
                            <div class="mb-1.5 sm:mb-2 flex justify-between">
                                <div class="text-xxs sm:text-xs lg:text-sm text-slate-500">
                                    {{ __($question->forumSubcategory->forumCategory->name) }}.
                                    {{ __($question->forumSubcategory->name) }}
                                </div>

                                <div class="text-right ml-3 sm:ml-5">
                                    <div class="mb-0.5 sm:mb-1 text-xxs sm:text-xs text-slate-500 whitespace-nowrap">
                                        {{ __('Views') }}: <span>{{ $question->views_count }}</span>
                                    </div>
                                    <div class="text-xxs sm:text-xs text-slate-500 whitespace-nowrap">
                                        {{ __('Answers') }}:
                                        <span>{{ $question->moderated_forum_answers_count }}</span>
                                    </div>
                                </div>
                            </div>

                            <h3
                                class="whitespace-nowrap truncate text-xs sm:text-sm lg:text-base text-slate-600 dark:text-slate-400 group-hover:text-slate-800 dark:group-hover:text-slate-200 font-bold">
                                {{ $question->theme }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>

            @if ($questions->hasPages())
                <div class="mt-8 sm:mt-12 lg:mt-14">
                    {{ $questions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
