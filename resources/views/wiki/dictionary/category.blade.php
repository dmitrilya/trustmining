<x-home-layout :data="$data" :title="__('dictionary.' . $category->name . '.title')" :description="__('dictionary.' . $category->name . '.description')" :header="__('dictionary.' . $category->name . '.name')">
    <x-breadcrumbs.breadcrumbs>
        <x-breadcrumbs.breadcrumb position="1" href="{{ route('wiki') }}" :name="__('meta.wiki.header')" />
        <x-breadcrumbs.breadcrumb position="2" href="{{ route('dictionary') }}" :name="__('Crypto dictionary')" />
        <x-breadcrumbs.breadcrumb position="3" :name="__('dictionary.' . $category->name . '.name')" />
    </x-breadcrumbs.breadcrumbs>

    <div class="text-sm sm:text-base text-slate-600 dark:text-slate-400 mb-4 sm:mb-6 lg:mb-8 max-w-2xl">
        {{ __("dictionary.$category->name.caption") }}
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-2">
        @foreach ($category->dictionaryTerms as $term)
            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl p-2 sm:p-3 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold sm:text-lg text-slate-800 dark:text-slate-200 mb-1">
                        {{ __("dictionary.$category->name.terms.$term->name.name") }}
                    </h3>

                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mb-2 sm:mb-3">
                        {{ __("dictionary.$category->name.terms.$term->name.caption") }}
                    </p>
                </div>

                <a class="block w-fit ml-auto text-xs sm:text-sm text-indigo-500 hover:text-indigo-600"
                    href="{{ route('dictionary.term', ['dictionaryCategory' => $category->name, 'dictionaryTerm' => $term->name]) }}">{{ __('Details') }}</a>
            </div>
        @endforeach
    </div>
</x-home-layout>
