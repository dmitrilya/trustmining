<section class="mt-4 sm:mt-6 lg:mt-8">
    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
        <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
            {{ __('Frequently Asked Questions') }}
        </h2>
    </div>

    @php
        $article = App\Models\Insight\Content\Article::find(10000001);
    @endphp

    <div itemscope itemtype="https://schema.org/FAQPage" class="max-w-3xl mx-auto space-y-4" x-data="{ active: null }">
        <div itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"
            class="border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm bg-slate-100 dark:bg-slate-900 border-l-4 border-l-indigo-500 dark:border-l-indigo-500">
            <button @click="active !== 1 ? active = 1 : active = null"
                class="flex justify-between items-center w-full p-4 text-left font-semibold text-slate-800 dark:text-slate-200 transition-all">
                <span itemprop="name">
                    {{ __('faq.metrics.network.difficulty.question_1', ['name' => $coin->name, 'short' => $coin->abbreviation]) }}
                </span>
                <svg class="ml-2 sm:ml-3 w-5 h-5 transition-transform duration-300"
                    :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer" x-show="active === 1"
                x-collapse x-cloak>
                <div itemprop="text"
                    class="p-4 text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800">
                    {{ __('faq.metrics.network.difficulty.answer_1', ['name' => $coin->name, 'short' => $coin->abbreviation]) }}
                    @if ($article)
                        <a href="{{ route('insight.article.show', ['channel' => $article->channel->slug, 'article' => $article->id . '-' . Str::slug($article->title)]) }}"
                            class="inline text-indigo-500 hover:text-indigo-600">
                            {{ __('What is network difficulty?') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"
            class="border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm bg-slate-100 dark:bg-slate-900 border-l-4 border-l-indigo-500 dark:border-l-indigo-500">
            <button @click="active !== 2 ? active = 2 : active = null"
                class="flex justify-between items-center w-full p-4 text-left font-semibold text-slate-800 dark:text-slate-200 transition-all">
                <span itemprop="name">
                    {{ __('faq.metrics.network.difficulty.question_2', ['short' => $coin->abbreviation]) }}
                </span>
                <svg class="ml-2 sm:ml-3 w-5 h-5 transition-transform duration-300"
                    :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer" x-show="active === 2"
                x-collapse x-cloak>
                <div itemprop="text"
                    class="p-4 text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800">
                    {{ __('faq.metrics.network.difficulty.answer_2', ['name' => $coin->name]) }}
                </div>
            </div>
        </div>

        <div itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"
            class="border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm bg-slate-100 dark:bg-slate-900 border-l-4 border-l-indigo-500 dark:border-l-indigo-500">
            <button @click="active !== 3 ? active = 3 : active = null"
                class="flex justify-between items-center w-full p-4 text-left font-semibold text-slate-800 dark:text-slate-200 transition-all">
                <span itemprop="name">
                    {{ __('faq.metrics.network.difficulty.question_3', ['name' => $coin->name]) }}
                </span>
                <svg class="ml-2 sm:ml-3 w-5 h-5 transition-transform duration-300"
                    :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer" x-show="active === 3"
                x-collapse x-cloak>
                <div itemprop="text"
                    class="p-4 text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800">
                    {{ __('faq.metrics.network.difficulty.answer_3', ['short' => $coin->abbreviation]) }}
                </div>
            </div>
        </div>

        <div itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"
            class="border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm bg-slate-100 dark:bg-slate-900 border-l-4 border-l-indigo-500 dark:border-l-indigo-500">
            <button @click="active !== 4 ? active = 4 : active = null"
                class="flex justify-between items-center w-full p-4 text-left font-semibold text-slate-800 dark:text-slate-200 transition-all">
                <span itemprop="name">
                    {{ __('faq.metrics.network.difficulty.question_4', ['short' => $coin->abbreviation]) }}
                </span>
                <svg class="ml-2 sm:ml-3 w-5 h-5 transition-transform duration-300"
                    :class="active === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer" x-show="active === 4"
                x-collapse x-cloak>
                <div itemprop="text"
                    class="p-4 text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800 space-y-2">
                    {{ __('faq.metrics.network.difficulty.answer_4', ['name' => $coin->name, 'short' => $coin->abbreviation]) }}
                </div>
            </div>
        </div>
    </div>
</section>
