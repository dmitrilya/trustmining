<div x-data="{ show: false }" class="ql-snow">
    <h2 class="font-extrabold tracking-tight text-slate-800 dark:text-slate-200">
        {{ __('Description') }}</h2>

    <div itemprop="description" style="overflow-y: hidden; max-height: 5rem" :style="{ maxHeight: show ? $el.scrollHeight + 'px' : '5rem' }"
        class="ql-editor mt-5 text-xxs xxs:text-xs sm:text-sm text-slate-600 dark:text-slate-400 transition ease-in-out">
        <p>
            {!! __('gpu_description.text_p1', ['model' => $model->name, 'brand' => $brand->name, 'country' => __($brand->country)]) !!}
        </p>
        <p><br></p>
        <h2>{{ __('gpu_description.h2_specs') }}</h2>
        <p>{!! __('gpu_description.text_specs_p1', ['model' => $model->name]) !!}</p>
        <p><br></p>
        <ol>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                    class="ql-color-secondary-text-color"><b>{{ __('gpu_description.labels.max_power') }}</b></span>
                {!! __('gpu_description.specs.max_power', ['power' => $model->max_power, 'unit' => __('kW·h')]) !!}
            </li>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                    class="ql-color-secondary-text-color"><b>{{ __('gpu_description.labels.phases') }}</b></span>
                {!! __('gpu_description.specs.phases', ['phases' => $model->phases]) !!}
            </li>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                    class="ql-color-secondary-text-color"><b>{{ __('gpu_description.labels.economy') }}</b></span>
                {!! __('gpu_description.specs.economy', ['consumption' => $model->fuel_consumption]) !!}
            </li>
        </ol>
        <p><br></p>
        <h2>{{ __('gpu_description.h2_engine') }}</h2>
        <p>
            {!! __('gpu_description.text_engine_p1', [
                'model' => $model->gpuEngineModel->name,
                'brand' => $model->gpuEngineModel->gpuEngineBrand->name,
                'country' => $model->gpuEngineModel->gpuEngineBrand->country,
            ]) !!}
        </p>
        <p><br></p>
        <h3>{{ __('gpu_description.h3_engine_title') }}</h3>
        <ol>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                    class="ql-color-secondary-text-color"><b>{{ __('gpu_description.labels.volume') }}</b></span>
                {!! __('gpu_description.engine_specs.volume', ['volume' => $model->gpuEngineModel->volume]) !!}
            </li>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                    class="ql-color-secondary-text-color"><b>{{ __('gpu_description.labels.configuration') }}</b></span>
                {!! __('gpu_description.engine_specs.cylinders', ['cylinders' => $model->gpuEngineModel->cylinders]) !!}
            </li>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                    class="ql-color-secondary-text-color"><b>{{ __('gpu_description.labels.speed') }}</b></span>
                {!! __('gpu_description.engine_specs.rpm', ['rpm' => $model->gpuEngineModel->rpm]) !!}
            </li>
        </ol>
        <p><br></p>
        <h2>{!! __('gpu_description.h2_advantages', ['brand' => $brand->name]) !!}</h2>
        <p><br></p>
        <ol>
            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span><span class="ql-color-secondary-text-color">{!! __('gpu_description.advantages.cost') !!}
            </li>
            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span><span class="ql-color-secondary-text-color">{!! __('gpu_description.advantages.ecology', ['brand' => $model->gpuEngineModel->gpuEngineBrand->name]) !!}
            </li>
            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span><span class="ql-color-secondary-text-color">{!! __('gpu_description.advantages.cogen', ['model' => $model->name]) !!}
            </li>
            <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span><span class="ql-color-secondary-text-color">{!! __('gpu_description.advantages.durability', ['country' => $brand->country]) !!}
            </li>
        </ol>
        <p><br></p>
        <h2>{{ __('gpu_description.h2_safety') }}</h2>
        <p>{{ __('gpu_description.text_safety') }}</p>
        <p><br></p>
        <h2>{{ __('gpu_description.h2_usage') }}</h2>
        <p>{!! __('gpu_description.text_usage', ['power' => $model->max_power, 'unit' => __('kW·h'), 'engine_model' => $model->gpuEngineModel->name]) !!}</p>
        <ol>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>{{ __('gpu_description.usage_list.f1') }}</li>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>{{ __('gpu_description.usage_list.f2') }}</li>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>{{ __('gpu_description.usage_list.f3') }}</li>
            <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>{{ __('gpu_description.usage_list.f4') }}</li>
        </ol>
        <p><br></p>
        <h2>{{ __('gpu_description.h2_summary') }}</h2>
        <p><br></p>
        <p>{!! __('gpu_description.text_summary', ['brand' => $brand->name, 'model' => $model->name]) !!}</p>
    </div>

    <button @click="show = !show" class="mt-2 block w-fit ml-auto text-xs xs:text-sm text-indigo-500 hover:text-indigo-600">
        <span x-text="!show ? '{{ __('Show all') }}' : '{{ __('Hide') }}'"></span>
    </button>
</div>
