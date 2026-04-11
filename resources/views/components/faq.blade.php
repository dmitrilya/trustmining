@props(['i', 'question', 'answer'])

<div itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"
    class="border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm bg-slate-100 dark:bg-slate-900 border-l-4 border-l-indigo-500 dark:border-l-indigo-500">
    <button @click="active !== {{ $i }} ? active = {{ $i }} : active = null"
        class="flex justify-between items-center w-full p-4 text-left font-semibold text-sm sm:text-base text-slate-800 dark:text-slate-200 transition-all">
        <span itemprop="name">{!! $question !!}</span>
        <svg class="ml-2 sm:ml-3 w-5 h-5 transition-transform duration-300"
            :class="active === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer"
        x-show="active === {{ $i }}" x-collapse x-cloak>
        <div itemprop="text"
            class="p-4 text-xs sm:text-sm text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800">
            {!! $answer !!}
        </div>
    </div>
</div>
