@props(['href'])

<a type="button" href="{{ $href }}"
    class="bg-white dark:bg-slate-950 rounded-lg text-slate-600 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-slate-200 dark:focus:ring-slate-700 prev-btn">
    <svg class="w-4 h-4 rtl:rotate-180 text-slate-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13 5H1m0 0 4 4M1 5l4-4"></path>
    </svg>
</a>
