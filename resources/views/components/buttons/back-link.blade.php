@props(['href'])

<a type="button" href="{{ $href }}"
    class="bg-white dark:bg-slate-950 rounded-lg text-slate-600 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-slate-200 text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-slate-200 dark:focus:ring-slate-700 prev-btn">
    <svg class="w-4 h-4 text-slate-800 dark:text-slate-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13 5H1m0 0 4 4M1 5l4-4"></path>
    </svg>
</a>
