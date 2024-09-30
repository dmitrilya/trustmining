<x-app-layout>
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg px-2 py-4 sm:px-4 md:p-6">
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-2 px-4 sm:px-6 lg:px-8">
                    <li class="text-sm">
                        <div class="flex items-center">
                            <a href="#"
                                class="font-medium text-gray-500 hover:text-gray-600">{{ __('Catalog of models') }}</a>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach ($brands as $brand)
                    <div class="flex justify-center">
                        <a href="{{ route('database.brand', ['asicBrand' => strtolower(str_replace(' ', '_', $brand->name))]) }}"
                            class="hover:drop-shadow-md">
                            <img class="h-10 sm:h-14 xl:h-20"
                                src="{{ Storage::url('public/database/brands/' . $brand->name . '.webp') }}"
                                alt="{{ $brand->name }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6 mt-6">
            <h2 class="text-xl font-medium text-gray-800 mb-6">{{ __('Popular models') }}</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                @foreach ($popularModels as $model)
                    <a href="{{ route('database.model', [
                        'asicBrand' => strtolower(str_replace(' ', '_', $model->asicBrand->name)),
                        'asicModel' => strtolower(str_replace(' ', '_', $model->name)),
                    ]) }}"
                        class="group">
                        @if (count($model->images))
                            <img class="w-full rounded-lg mb-2 shadow-md group-hover:shadow-lg"
                                src="{{ Storage::url($model->images[0]) }}" alt="{{ $model->name }}">
                        @endif

                        <h5 class="font-semibold text-gray-500 text-sm group-hover:text-gray-900">
                            {{ $model->name }}
                        </h5>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
