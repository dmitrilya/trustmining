@props(['i', 'question', 'answer'])

<div itemprop="mainEntity" itemscope itemtype="https://schema.org"
    class="border rounded-xl overflow-hidden shadow bg-white/40 dark:bg-slate-900/40 border-l-4 border-l-indigo-600 dark:border-l-indigo-600 transition duration-300"
    :class="active == {{ $i }} ? 'border-indigo-600' : 'border-slate-300 dark:border-slate-700'">

    <button type="button" @click="active !== {{ $i }} ? active = {{ $i }} : active = null"
        class="flex justify-between items-center w-full p-4 text-left font-semibold text-sm sm:text-base text-slate-800 dark:text-slate-200 transition">
        <span itemprop="name">{!! $question !!}</span>
        <svg class="ml-2 sm:ml-3 w-5 h-5 transition duration-300" :class="active === {{ $i }} ? 'rotate-180' : ''" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org" class="grid grid-rows-[0fr] transition duration-300 ease-in-out"
        :class="active === {{ $i }} ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">

        <div class="min-h-0">
            <div itemprop="text" class="p-4 text-xs sm:text-sm text-slate-600 dark:text-slate-400 border-t border-slate-300 dark:border-slate-800">
                {!! $answer !!}
            </div>
        </div>
    </div>
</div>
