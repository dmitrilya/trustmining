<x-app-layout :title="__('meta.widjets.title')" :description="__('meta.widjets.description')">
    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8" x-data="{ widjet: '{{ request()->widjet ?? 'calculator' }}' }">
        <div class="flex flex-wrap gap-2 sm:gap-3 mb-8 lg:mb-12">
            @foreach (['calculator' => 'Mining calculator', 'difficulty' => 'Network difficulty', 'coin-stat' => 'Coin information'] as $widjet => $widjet_header)
                <div @click="widjet = '{{ $widjet }}'" class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 group border rounded-md"
                    :class="widjet ==
                        '{{ $widjet }}' ?
                        'bg-indigo-200 dark:bg-indigo-600 border-indigo-500 dark:border-indigo-700' :
                        'border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700'">
                    <h4 class="font-semibold text-xs lg:text-sm"
                        :class="widjet ==
                            '{{ $widjet }}' ? 'text-indigo-500 dark:text-slate-200' :
                            'text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-slate-200'">
                        {{ __($widjet_header) }}
                    </h4>
                </div>
            @endforeach
        </div>

        <div class="space-y-8 lg:space-y-12" x-show="widjet == 'calculator'">
            @include('widjets.calculator')
        </div>

        <div class="space-y-8 lg:space-y-12" x-show="widjet == 'difficulty'" style="display: none">
            @include('widjets.difficulty')
        </div>

        <div class="space-y-8 lg:space-y-12" x-show="widjet == 'coin-stat'" style="display: none">
            @include('widjets.coin-stat')
        </div>
    </div>
</x-app-layout>
