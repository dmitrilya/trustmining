<button {{ $attributes->merge(['type' => 'button', 'class' => 'box-border inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-900 border-0 ring-1 ring-inset ring-gray-200 dark:ring-zinc-700 rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest shadow-sm dark:shadow-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-800 hover:shadow-md dark:shadow-zinc-800 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
