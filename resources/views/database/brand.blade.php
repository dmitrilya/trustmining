<x-app-layout>
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4 md:p-6">
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-2">
                    <li>
                        <div class="flex items-center">
                            <a href="{{ route('database') }}"
                                class="mr-2 text-sm font-medium text-gray-900">{{ __('Catalog of models') }}</a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true"
                                class="h-5 w-4 text-gray-300">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li class="text-sm">
                        <div class="flex items-center">
                            <a href="#"
                                class="font-medium text-gray-500 hover:text-gray-600">{{ $brand->name }}</a>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach ($models as $model)
                    <a href="{{ route('database.model', [
                        'asicBrand' => strtolower(str_replace(' ', '_', $brand->name)),
                        'asicModel' => strtolower(str_replace(' ', '_', $model->name)),
                    ]) }}"
                        class="group">
                        <h5 class="font-semibold text-gray-500 text-sm group-hover:text-gray-900">
                            {{ $model->name }}
                        </h5>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4 md:p-6 mt-6">
            <h2 class="text-xl font-medium text-gray-800 mb-6">{{ __('Popular models') }}</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                @foreach ($models->sortByDesc('views_count')->take(4) as $model)
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
