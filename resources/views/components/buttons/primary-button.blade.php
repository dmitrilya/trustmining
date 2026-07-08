<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-2 lg:py-2.5 bg-primary-gradient rounded-lg font-extrabold text-xs sm:text-sm text-white uppercase tracking-widest hover:opacity-90 focus:outline-none focus:opacity-90']) }}>
    {{ $slot }}
</button>
