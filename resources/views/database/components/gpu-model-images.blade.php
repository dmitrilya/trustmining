@switch(count($model->images))
    @case(1)
        <div class="mx-auto sm:grid sm:grid-cols-3 lg:gap-8">
            <div class="col-start-2">
                <img src="{{ Storage::url('gpus/' . $model->images[0]) }}" alt="{{ $model->name }}"
                    class="w-full rounded-lg object-cover object-center">
            </div>
        </div>
    @break

    @case(2)
        <div class="mx-auto sm:grid sm:grid-cols-2 lg:grid-cols-6 gap-8">
            <div class="lg:col-span-2 lg:col-start-2 hidden sm:block">
                <img src="{{ Storage::url('gpus/' . $model->images[0]) }}" alt="{{ $model->name }}"
                    class="w-full rounded-lg object-cover object-center">
            </div>
            <div class="lg:col-span-2">
                <img src="{{ Storage::url('gpus/' . $model->images[1]) }}" alt="{{ $model->name }}"
                    class="w-full rounded-lg object-cover object-center">
            </div>
        </div>
    @break

    @case(3)
        <div class="mx-auto sm:grid sm:grid-cols-3 gap-4 lg:gap-8">
            <div class="hidden sm:block">
                <img src="{{ Storage::url('gpus/' . $model->images[0]) }}" alt="{{ $model->name }}"
                    class="w-full rounded-lg object-cover object-center">
            </div>
            <div class="hidden sm:block">
                <img src="{{ Storage::url('gpus/' . $model->images[1]) }}" alt="{{ $model->name }}"
                    class="w-full rounded-lg object-cover object-center">
            </div>
            <div class="overflow-hidden rounded-lg">
                <img src="{{ Storage::url('gpus/' . $model->images[2]) }}" alt="{{ $model->name }}"
                    class="w-full rounded-lg object-cover object-center">
            </div>
        </div>
    @break

    @case(4)
        <div class="mx-auto sm:grid sm:grid-cols-3 gap-4 lg:gap-8">
            <div class="hidden sm:flex items-center">
                <img src="{{ Storage::url('gpus/' . $model->images[0]) }}" alt="{{ $model->name }}"
                    class="w-full rounded-lg object-cover object-center">
            </div>
            <div class="hidden sm:grid sm:grid-cols-1 gap-4 lg:gap-8">
                <div class="overflow-hidden rounded-lg">
                    <img src="{{ Storage::url('gpus/' . $model->images[1]) }}" alt="{{ $model->name }}"
                        class="w-full rounded-lg object-cover object-center">
                </div>
                <div class="overflow-hidden rounded-lg">
                    <img src="{{ Storage::url('gpus/' . $model->images[2]) }}" alt="{{ $model->name }}"
                        class="w-full rounded-lg object-cover object-center">
                </div>
            </div>
            <div class="overflow-hidden rounded-lg flex items-center">
                <img src="{{ Storage::url('gpus/' . $model->images[3]) }}" alt="{{ $model->name }}"
                    class="w-full rounded-lg object-cover object-center">
            </div>
        </div>
    @break
@endswitch
