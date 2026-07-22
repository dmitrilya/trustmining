<button x-data="{
    showTooltip: false,
    initTooltip() {
        const tooltipHiddenUntil = localStorage.getItem('roulette_tooltip_shown_today');
        const isShownToday = false;//tooltipHiddenUntil && Date.now() < parseInt(tooltipHiddenUntil, 10);

        if ({{ $timeToSpin }} === 0 && !isShownToday) {
            setTimeout(() => {
                this.showTooltip = true;

                const now = new Date();
                const endOfDay = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59, 999);
                localStorage.setItem('roulette_tooltip_shown_today', endOfDay.getTime().toString());

                setTimeout(() => { this.showTooltip = false; }, 3000);
            }, 10000);
        }
    }
}" x-init="initTooltip()" aria-label="{{ __('TM Roulette') }}" @click="$dispatch('open-modal', 'roulette')"
    class="relative inline-flex items-center text-sm text-center focus:outline-none">
    <svg class="w-5 h-5 opacity-80 hover:opacity-100" aria-hidden="true" viewBox="0 0 20 20"
        :class="{{ $timeToSpin }} === 0 ? '[animation:spin_10s_linear_infinite,colorPulse_3s_ease-in-out_infinite] hover:[animation-play-state:paused]' : ''">
        <defs>
            <linearGradient id="logo-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#40ff9f" />
                <stop offset="33%" stop-color="#14aeff" />
                <stop offset="66%" stop-color="#7966ff" />
                <stop offset="100%" stop-color="#404099" />
            </linearGradient>
        </defs>
        <g fill="url(#logo-gradient)">
            <path d="M17 1L13 3.5L16.5 7L17 1Z" />
            <path
                d="M10 2C5.58 2 2 5.58 2 10C2 14.42 5.58 18 10 18C14.42 18 18 14.42 18 10C18 5.58 14.42 2 10 2ZM10 4C10.55 4 11 4.45 11 5V6.18C12.46 6.54 13.46 7.54 13.82 9H15C15.55 9 16 9.45 16 10C16 10.55 15.55 11 15 11H13.82C13.46 12.46 12.46 13.46 11 13.82V15C11 15.55 10.55 16 10 16C9.45 16 9 15.55 9 15V13.82C7.54 13.46 6.54 12.46 6.18 11H5C4.45 11 4 10.55 4 10C4 9.45 4.45 9 5 9H6.18C6.54 7.54 7.54 6.54 9 6.18V5C9 4.45 9.45 4 10 4ZM10 8C8.9 8 8 8.9 8 10C8 11.1 8.9 12 10 12C11.1 12 12 11.1 12 10C12 8.9 11.1 8 10 8Z" />
        </g>
    </svg>

    <div x-show="showTooltip" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        class="absolute top-full left-1/2 -translate-x-1/2 mt-3 z-50 w-48 p-4 bg-slate-900 border text-white rounded-xl pointer-events-none text-center"
        style="display: none;">
        <div class="absolute bottom-full left-1/2 -translate-x-1/2 w-0 h-0 border-l-[6px] border-l-transparent border-r-[6px] border-r-transparent border-b-[6px] border-b-slate-900"></div>

        <div class="text-xxs font-black uppercase tracking-wider text-emerald-400 mb-1 flex items-center justify-center gap-2">
            <span class="w-1.5 h-1.5 mb-1 rounded-full bg-emerald-400 animate-pulse"></span>
            {{ __('Spin available!') }}
        </div>
        <p class="text-xxs font-medium leading-normal text-slate-300">
            {{ __('Take part in the ASIC giveaway or get a discount on your purchase') }}
        </p>
    </div>
</button>
