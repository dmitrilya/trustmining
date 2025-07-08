<button {{ $attributes->merge(['type' => 'button', 'class' => 'box-border inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border-0 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 hover:shadow-md focus:outline-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
