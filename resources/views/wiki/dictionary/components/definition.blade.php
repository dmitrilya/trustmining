<div class="p-3 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl ">
    <h2 class="text-xs text-slate-500 uppercase tracking-widest mb-6">
        {{ __('Definition of the day') }}
    </h2>

    @php
        $dayOfYear = now()->dayOfYear;
        $seed = $dayOfYear + now()->year * 1000;

        $term = App\Models\Dictionary\DictionaryTerm::orderByRaw("RAND($seed)")
            ->with(['dictionaryCategory'])
            ->first();
    @endphp

    <div>
        <h3 class="font-bold sm:text-lg text-slate-800 dark:text-slate-200 mb-1">
            {{ __("dictionary.{$term->dictionaryCategory->name}.terms.$term->name.name") }}
        </h3>

        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mb-2 sm:mb-3">
            {{ __("dictionary.{$term->dictionaryCategory->name}.terms.$term->name.caption") }}
        </p>
    </div>

    <a class="block w-fit ml-auto text-xs sm:text-sm text-indigo-500 hover:text-indigo-600"
        href="{{ route('dictionary.term', ['dictionaryCategory' => $term->dictionaryCategory->name, 'dictionaryTerm' => $term->name]) }}">{{ __('Details') }}</a>
</div>
