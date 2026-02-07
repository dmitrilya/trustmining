<button {{ $attributes->merge(['type' => 'button', 'class' => 'box-border inline-flex items-center px-4 py-2 bg-white/60 dark:bg-zinc-900/60 border-0 ring-1 ring-inset ring-gray-200 dark:ring-zinc-700 rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest shadow-[0_0_10px_rgba(64,64,153,0.15)] dark:shadow-[0_0_15px_rgba(64,255,159,0.12)] hover:shadow-[0_0_10px_rgba(64,64,153,0.4)] dark:hover:shadow-[0_0_15px_rgba(64,255,159,0.35)] focus:outline-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
