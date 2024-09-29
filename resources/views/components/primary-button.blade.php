<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-2 bg-primary-gradient rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none focus:opacity-90']) }}>
    {{ $slot }}
</button>
