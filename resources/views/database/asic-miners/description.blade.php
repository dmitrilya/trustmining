<div x-data="{ show: false }" class="ql-snow">
    <h2 class="sr-only">{{ __('Description') }}</h2>

    <div itemprop="description" style="overflow-y: hidden; max-height: 5rem" :style="{ maxHeight: show ? $el.scrollHeight + 'px' : '5rem' }"
        class="ql-editor mt-5 text-xxs xxs:text-xs sm:text-sm text-slate-600 dark:text-slate-400 transition ease-in-out">
        <p>
            {!! __('descriptions.asic.text_p1', [
                'model' => $model->name,
                'brand' => $brand->name,
                'release' => $model->release->locale(app()->getLocale())->translatedFormat('F Y'),
            ]) !!}
        </p>
        <p></br></p>
        <h2>{{ __('descriptions.asic.h2_specs') }}</h2>
        <p>{!! __('descriptions.asic.text_specs_p1', ['model' => $model->name]) !!}</p>
        <p><br></p>
        <p>{{ __('descriptions.asic.text_specs_p2') }}</p>
        <ol>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                    class="ql-color-secondary-text-color"><b>{{ __('descriptions.asic.labels.algorithm') }}</b></span>
                {!! __('descriptions.asic.specs.algorithm', ['algorithm' => $model->algorithm->name]) !!}
            </li>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                    class="ql-color-secondary-text-color"><b>{{ __('descriptions.asic.labels.hashrate') }}</b></span>
                {!! __('descriptions.asic.specs.hashrate', ['hashrate' => $selectedVersion['h'] . $selectedVersion['m']]) !!}
            </li>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                    class="ql-color-secondary-text-color"><b>{{ __('descriptions.asic.labels.power') }}</b></span>
                {!! __('descriptions.asic.specs.power', ['power' => $selectedVersion['e'] * $selectedVersion['h']]) !!}
            </li>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                    class="ql-color-secondary-text-color"><b>{{ __('descriptions.asic.labels.efficiency') }}</b></span>
                {!! __('descriptions.asic.specs.efficiency', ['efficiency' => $selectedVersion['e']]) !!}
            </li>
        </ol>
        <p></br></p>
        <h2>{{ __('descriptions.asic.h2_assets') }}</h2>
        <p>
            {!! __('descriptions.asic.text_assets', [
                'algorithm' => $model->algorithm->name,
                'coins' => collect($algorithms[$selectedVersion['a']]['p'])->pluck('c')->flatten(1)->pluck('n')->implode(', '),
            ]) !!}
        </p>
        <p></br></p>
        <h2>{{ __('descriptions.asic.h2_cooling') }}</h2>
        <p>{{ __('descriptions.asic.text_cooling') }}</p>
        <p>
        <p><br></p>

        {!! __('descriptions.asic.cooling_types.' . $model->cooling_type->name) !!}

        </p>
        <p><br></p>
        <h2>{!! __('descriptions.asic.h2_advantages', ['model' => $model->name]) !!}</h2>
        <ol>
            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span><span class="ql-color-secondary-text-color">{!! __('descriptions.asic.advantages.durability') !!}</li>
            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span><span class="ql-color-secondary-text-color">{!! __('descriptions.asic.advantages.management') !!}
            </li>
            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span><span class="ql-color-secondary-text-color">{!! __('descriptions.asic.advantages.setup') !!}
            </li>
        </ol>
        <p><br></p>
        <h2>{{ __('descriptions.asic.h2_summary') }}</h2>
        <p><br></p>
        <p>
            {!! __('descriptions.asic.text_summary', ['brand' => $brand->name, 'model' => $model->name]) !!}
        </p>
    </div>

    <button @click="show = !show" class="mt-2 block w-fit ml-auto text-xs xs:text-sm text-indigo-500 hover:text-indigo-600">
        <span x-text="!show ? '{{ __('Show all') }}' : '{{ __('Hide') }}'"></span>
    </button>
</div>
