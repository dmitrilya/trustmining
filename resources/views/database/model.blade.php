<x-app-layout>
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg px-2 py-4 sm:px-4 md:p-6">
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol role="list"
                    class="flex items-center space-x-2 px-4 sm:px-6 lg:px-8">
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
                    <li>
                        <div class="flex items-center">
                            <a href="{{ route('database.brand', ['asicBrand' => strtolower(str_replace(' ', '_', $brand->name))]) }}"
                                class="mr-2 text-sm font-medium text-gray-900">{{ $brand->name }}</a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-4 text-gray-300">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li class="text-sm">
                        <a href="#" aria-current="page"
                            class="font-medium text-gray-500 hover:text-gray-600">{{ $model->name }}</a>
                    </li>
                </ol>
            </nav>

            @include('database.components.model-images')

            <div
                class="mx-auto px-4 pb-16 pt-10 sm:px-6 md:grid md:grid-cols-3 md:grid-rows-[auto,auto,1fr] md:gap-x-8 md:px-8 md:pb-24 md:pt-16">
                <div class="md:col-span-2 md:border-r md:border-gray-200 md:pr-8">
                    <h1 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl md:text-3xl">
                        {{ $model->name }}</h1>
                </div>

                <div class="mt-4 md:row-span-3 md:mt-0">
                    <h2 class="sr-only">Информация</h2>

                    <!-- Reviews -->
                    <div class="mt-4 sm:mt-6">
                        <h3 class="sr-only">{{ __('Reviews') }}</h3>
                        <div class="flex items-center" x-data="{ momentRating: {{ $model->moderatedReviews->count() ? $model->moderatedReviews->avg('rating') : 0 }} }">
                            <x-rating></x-rating>

                            <a href="{{ route('database.reviews', [
                                'asicBrand' => strtolower(str_replace(' ', '_', $brand->name)),
                                'asicModel' => strtolower(str_replace(' ', '_', $model->name)),
                            ]) }}"
                                class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ $model->moderatedReviews->count() }}
                                {{ __('reviews') }}</a>
                        </div>
                    </div>

                    <a class="block mt-4 sm:mt-6 md:mt-8"
                        href="{{ route('ads', ['models[]' => strtolower(str_replace(' ', '_', $model->name))]) }}">
                        <x-primary-button>{{ __('Find ads') }}</x-primary-button>
                    </a>
                </div>

                <div class="py-6 sm:py-8 md:col-span-2 md:col-start-1 md:border-r md:border-gray-200 md:pb-16 md:pr-8 md:pt-6">
                    <div>
                        <h3 class="sr-only">{{ __('Description') }}</h3>

                        <div class="space-y-6">
                            <p class="text-sm sm:text-base text-gray-900">{{ $model->description }}</p>
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-8 md:mt-10">
                        <h3 class="text-sm font-medium text-gray-900">Характеристики</h3>

                        <div class="mt-4">
                            <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                                <li class="text-gray-400">Алгоритм: <span class="text-gray-600">
                                        {{ $model->algorithm->name }}</span></li>
                                <li class="text-gray-400">Размер: <span class="text-gray-600">
                                        {{ $model->width }}см X {{ $model->length }}см X
                                        {{ $model->height }}см</span></li>
                                <li class="text-gray-400">Вес: <span class="text-gray-600">
                                        {{ $model->weight }}кг</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
