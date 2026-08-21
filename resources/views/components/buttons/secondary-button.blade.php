<button {{ $attributes->merge(['type' => 'button', 'class' => 'flex items-center justify-center px-4 py-2 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 border-0 ring-1 ring-inset ring-slate-300 dark:ring-slate-700 rounded-lg font-extrabold text-xs sm:text-sm text-slate-800 dark:text-slate-200 uppercase tracking-widest shadow hover:shadow-md shadow-logo-color hover:shadow-logo-color hover:-translate-y-0.5 focus:outline-none disabled:opacity-25 transition ease-in-out duration-100']) }}>
    {{ $slot }}
</button>
