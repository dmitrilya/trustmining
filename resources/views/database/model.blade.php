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

            {{-- @include('database.components.model-images') --}}

            <div class="mx-auto md:grid md:grid-cols-3 md:grid-rows-[auto,auto,1fr] mt-6 md:mt-12">
                <div class="md:col-span-2 md:border-r md:border-gray-200 md:pr-8">
                    <h1 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl md:text-3xl">
                        {{ $model->name }}</h1>
                </div>

                <div class="mt-4 md:row-span-3 md:mt-0 md:pl-6 lg:pl-12 xl:pl-16">
                    <h2 class="sr-only">Информация</h2>

                    <!-- Reviews -->
                    <div class="mt-4 sm:mt-6">
                        <h3 class="sr-only">{{ __('Reviews') }}</h3>
                        <div class="flex items-center" x-data="{ momentRating: {{ $model->moderatedReviews->count() ? $model->moderatedReviews->avg_rating : 0 }} }">
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
                        href="{{ route('ads', ['model' => strtolower(str_replace(' ', '_', $model->name))]) }}">
                        <x-primary-button>{{ __('Find ads') }}</x-primary-button>
                    </a>
                </div>

                <div
                    class="py-6 sm:py-8 md:col-span-2 md:col-start-1 md:border-r md:border-gray-200 md:pb-16 md:pr-8 md:pt-6">
                    @php
                        $algorithm = $model->algorithm()->with('coins')->first();
                    @endphp

                    <div class="text-sm text-gray-400">{{ __('Algorithm') }}: <span class="text-gray-600">
                            {{ $algorithm->name }}</span></div>

                    <div class="grid gap-4 xl:gap-8 grid-cols-1 xl:grid-cols-2 mt-6 sm:mt-8 md:mt-10">
                        @foreach ($model->asicVersions()->with(['ads:price'])->get() as $version)
                            <div>
                                @php
                                    $avgPrice = $version->ads->avg('price');
                                @endphp

                                <a href="{{ route('ads', ['model' => strtolower(str_replace(' ', '_', $model->name)), 'asic_version_id' => $version->id]) }}"
                                    class="flex items-center text-sm md:text-base text-gray-900 underline font-bold mb-4">
                                    {{ $version->hashrate }} {{ $algorithm->measurement }}
                                    <svg class="w-4 h-4 rotate-180 ml-2 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"></path>
                                    </svg>
                                </a>

                                <div class="text-sm text-gray-400">{{ __('Average price') }}: <span
                                        class="text-gray-600">
                                        {{ $avgPrice ? $avgPrice : __('No ads') }}</span></div>

                                <h3 class="text-sm font-medium text-gray-900 mt-4 mb-3">{{ __('Income today') }}</h3>

                                <div class="space-y-2">
                                    @foreach ($algorithm->coins as $coin)
                                        <div class="flex items-center">
                                            <img src="/img/coins/{{ $coin->name }}.webp" alt="{{ $coin->name }}"
                                                class="w-5 mr-2">
                                            <div class="text-sm text-gray-400 mr-3">{{ $coin->name }}:</div>
                                            <div class="text-sm text-gray-600">
                                                {{ number_format($version->hashrate * $coin->profit, 8) }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- <div>
                        <h3 class="sr-only">{{ __('Description') }}</h3>

                        <p class="text-sm sm:text-base text-gray-900">{{ $model->description }}</p>
                    </div>

                    <div class="mt-6 sm:mt-8 md:mt-10">
                        <h3 class="text-sm font-medium text-gray-900">Характеристики</h3>

                        <ul role="list" class="list-disc space-y-2 pl-4 text-sm mt-4">
                            <li class="text-gray-400">Алгоритм: <span class="text-gray-600">
                                    {{ $model->algorithm->name }}</span></li>
                            <li class="text-gray-400">Размер: <span class="text-gray-600">
                                    {{ $model->width }}см X {{ $model->length }}см X
                                    {{ $model->height }}см</span></li>
                            <li class="text-gray-400">Вес: <span class="text-gray-600">
                                    {{ $model->weight }}кг</span></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
