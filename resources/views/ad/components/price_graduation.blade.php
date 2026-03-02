{{-- <div class="relative" x-data="show: false">
    <span @mouseover="open = true" @mouseover.away = "open = false" @click="open = !open" @click.away="open = false"
        class="flex items-center ml-3 text-xs font-semibold px-2 py-1 rounded-full {{ !isset($priceData['upper_bound']) || $ad->price * $ad->coin->rate > $priceData['upper_bound'] || $ad->price * $ad->coin->rate < $priceData['lower_bound'] ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
        <span>{{ isset($priceData['upper_bound']) ? ($ad->price * $ad->coin->rate > $priceData['upper_bound'] ? 'Выше рынка' : ($ad->price * $ad->coin->rate < $priceData['lower_bound'] ? 'Подозрительно дешево' : 'В рынке')) : 'Мало данных' }}</span>
        <svg class="size-4 sm:size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    </span>

    <div x-show="open" style="display: none"
        class="absolute top-7 left-1/2 -translate-x-1/2 px-2 py-3 sm:px-4 sm:py-5 space-y-3 sm:space-y-5 bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-lg z-20">
    
    </div>
</div> --}}

<span @mouseover="open = true" @mouseover.away = "open = false" @click="open = !open" @click.away="open = false"
    class="ml-3 text-center text-xs font-semibold px-2 py-1 rounded-full {{ !isset($priceData['upper_bound']) || $ad->price * $ad->coin->rate > $priceData['upper_bound'] || $ad->price * $ad->coin->rate < $priceData['lower_bound'] ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
    <span>{{ isset($priceData['upper_bound']) ? ($ad->price * $ad->coin->rate > $priceData['upper_bound'] ? __('Above market') : ($ad->price * $ad->coin->rate < $priceData['lower_bound'] ? __('Suspiciously cheap') : __('In the market'))) : __('Not enough data') }}</span>
</span>

<div x-data="{
    price: {{ $ad->price * $ad->coin->rate }},
    min: {{ $priceData['min'] }},
    max: {{ $priceData['max'] }},
    lower_bound: {{ $priceData['lower_bound'] ?? $priceData['min'] }},
    upper_bound: {{ $priceData['upper_bound'] ?? $priceData['max'] }},
    avg: {{ $priceData['average'] }},
    getPercent(val) {
        let p = this.max - this.min == 0 ? 50 : ((val - this.min) / (this.max - this.min)) * 100;
        return Math.max(0, Math.min(100, p));
    }
}" class="w-full">
    <div class="relative h-3 mt-8">
        <div class="absolute inset-0 bg-logo-gradient rounded-full"></div>
        <div class="absolute inset-0 bg-logo-gradient rounded-full opacity-20">
        </div>

        <div class="absolute bottom-0 text-slate-400" :style="`left: ${getPercent(avg)}%; transform: translateX(-50%);`">
            <div class="group relative flex flex-col items-center cursor-pointer">
                <span class="text-[10px] mb-2 w-max font-bold text-slate-400 uppercase">{{ __('Average price') }}</span>
                <div class="w-0.5 h-3 bg-slate-300"></div>
                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover:block z-10">
                    <div class="bg-slate-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap">
                        <span x-text="avg.toLocaleString()"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute top-0 flex flex-col items-center text-slate-400"
            :style="`left: ${getPercent(lower_bound)}%; transform: translateX(-50%);`">
            <div class="group relative cursor-pointer">
                <div class="w-0.5 h-3 bg-red-600"></div>
                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover:block z-10">
                    <div class="bg-slate-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap">
                        <span x-text="lower_bound.toLocaleString()"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute top-0 flex flex-col items-center text-slate-400"
            :style="`left: ${getPercent(upper_bound)}%; transform: translateX(-50%);`">
            <div class="group relative cursor-pointer">
                <div class="w-0.5 h-3 bg-red-600"></div>
                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover:block z-10">
                    <div class="bg-slate-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap">
                        <span x-text="upper_bound.toLocaleString()"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute top-1/2 -translate-y-1/2 shadow-lg"
            :style="`left: ${getPercent(price)}%; transform: translate(-50%, -50%);`">
            <div class="group relative cursor-pointer">
                <div class="size-5 rounded-full border-4 border-white shadow-md"
                    :class="price > upper_bound || price < lower_bound ? 'bg-red-500' : 'bg-transparent'">
                </div>
                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover:block z-10">
                    <div class="bg-slate-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap">
                        <span x-text="price.toLocaleString()"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-between mt-2 sm:mt-3 lg:mt-4 text-[11px] font-medium text-slate-400 uppercase">
        <span>{{ __('Min') }}: {{ number_format($priceData['min'], 0, '.', ' ') }}</span>
        <span>{{ __('Max') }}: {{ number_format($priceData['max'], 0, '.', ' ') }}</span>
    </div>
</div>
