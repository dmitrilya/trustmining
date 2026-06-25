<div
    class="card sm:max-w-md h-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden rounded-xl flex flex-col">
    <div class="w-full overflow-hidden rounded-xl justify-center items-center">
        <a class="block w-full" draggable="false" href="{{ $href }}" x-data="{ shown: false }"
            x-intersect.once.margin.300px="shown = true" aria-label="{{ $model->name }}">
            @php
                $previewxs = 'asic-miners/' . $model->slug . '_224' . '.webp';
                $previewsm = 'asic-miners/' . $model->slug . '_380' . '.webp';
            @endphp

            <template x-if="shown">
                <picture class="w-full">
                    <source media="(max-width: 430px)" srcset="{{ Storage::url($previewxs) }}">

                    <img class="w-full object-cover" src="{{ Storage::url($previewsm) }}" alt="{{ $model->name }}">
                </picture>
            </template>
        </a>
    </div>

    <div class="flex flex-col flex-grow justify-between p-2 sm:p-3">
        <div>
            <div class="text-sm md:text-base text-slate-950 dark:text-slate-50 font-bold">
                {{ $model->name }}
            </div>

            <x-characteristics class="mt-1 xs:mt-2">
                @foreach (array_merge($characteristics, [['name' => __('Algorithm'), 'value' => $model->algorithm->name]]) as $characteristic)
                    @php
                        $val =
                            $characteristic['value'] instanceof \Closure
                                ? $characteristic['value']($model)
                                : $characteristic['value'];
                    @endphp
                    <x-characteristic :name="$characteristic['name']" :value="$val" />
                @endforeach
            </x-characteristics>
        </div>

        <div class="mt-2 sm:mt-3">
            <div class="relative flex mt-2 items-center">
                <a class="block w-full" draggable="false" href="{{ $href }}">
                    <x-primary-button class="w-full justify-center">{{ $buttonText }}</x-primary-button>
                </a>
            </div>
        </div>
    </div>
</div>
