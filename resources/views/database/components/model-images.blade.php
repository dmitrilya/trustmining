@switch(count($model->images))
    @case(1)
        <div class="mx-auto sm:px-6 sm:grid sm:grid-cols-3 lg:gap-x-8 lg:px-8">
            <div class="col-start-2 overflow-hidden rounded-lg">
                <img src="{{ Storage::url($model->images[0]) }}" alt="{{ $model->name }}"
                    class="w-full object-cover object-center">
            </div>
        </div>
    @break

    @case(2)
        <div class="mx-auto sm:px-6 sm:grid sm:grid-cols-2 lg:grid-cols-6 gap-x-8 lg:px-8">
            <div class="lg:col-span-2 lg:col-start-2 hidden overflow-hidden rounded-lg sm:block">
                <img src="{{ Storage::url($model->images[0]) }}" alt="{{ $model->name }}"
                    class="w-full object-cover object-center">
            </div>
            <div class="lg:col-span-2 overflow-hidden rounded-lg">
                <img src="{{ Storage::url($model->images[1]) }}" alt="{{ $model->name }}"
                    class="w-full object-cover object-center">
            </div>
        </div>
    @break

    @case(3)
        <div class="mx-auto sm:px-6 sm:grid sm:grid-cols-3 lg:gap-x-8 lg:px-8">
            <div class="hidden overflow-hidden rounded-lg sm:block">
                <img src="{{ Storage::url($model->images[0]) }}" alt="{{ $model->name }}"
                    class="w-full object-cover object-center">
            </div>
            <div class="hidden overflow-hidden rounded-lg sm:block">
                <img src="{{ Storage::url($model->images[1]) }}" alt="{{ $model->name }}"
                    class="w-full object-cover object-center">
            </div>
            <div class="overflow-hidden rounded-lg">
                <img src="{{ Storage::url($model->images[2]) }}" alt="{{ $model->name }}"
                    class="w-full object-cover object-center">
            </div>
        </div>
    @break

    @case(4)
        <div class="mx-auto sm:px-6 sm:grid sm:grid-cols-3 lg:gap-x-8 lg:px-8">
            <div class="hidden overflow-hidden rounded-lg sm:flex items-center">
                <img src="{{ Storage::url($model->images[0]) }}" alt="{{ $model->name }}"
                    class="w-full object-cover object-center">
            </div>
            <div class="hidden sm:grid sm:grid-cols-1 sm:gap-y-8">
                <div class="overflow-hidden rounded-lg">
                    <img src="{{ Storage::url($model->images[1]) }}" alt="{{ $model->name }}"
                        class="w-full object-cover object-center">
                </div>
                <div class="overflow-hidden rounded-lg">
                    <img src="{{ Storage::url($model->images[2]) }}" alt="{{ $model->name }}"
                        class="w-full object-cover object-center">
                </div>
            </div>
            <div class="overflow-hidden rounded-lg flex items-center">
                <img src="{{ Storage::url($model->images[3]) }}" alt="{{ $model->name }}"
                    class="w-full object-cover object-center">
            </div>
        </div>
    @break
@endswitch
