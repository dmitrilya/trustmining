<x-app-layout :title="'ASIC майнер ' . $brand->name . ' ' . $model->name">
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

                @php
                    $hasTariff = ($user = \Auth::user()) && $user->tariff;
                @endphp

                <div class="mt-4 md:row-span-3 md:mt-0 md:pl-6 lg:pl-12 xl:pl-16">
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

                    @if ($versions->pluck('ads')->flatten()->count())
                        <a class="w-max mt-4 sm:mt-6 md:mt-8"
                            href="{{ route('ads', ['model' => strtolower(str_replace(' ', '_', $model->name))]) }}">
                            <x-primary-button>{{ __('Find ads') }}</x-primary-button>
                        </a>
                    @else
                        <x-primary-button
                            class="mt-4 sm:mt-6 md:mt-8 cursor-default opacity-60">{{ __('No ads') }}</x-primary-button>
                    @endif
                </div>

                <div
                    class="py-6 sm:py-8 md:col-span-2 md:col-start-1 md:border-r md:border-gray-200 md:pb-16 md:pr-8 md:pt-6">

                    <div class="text-sm text-gray-400">{{ __('Algorithm') }}: <span class="text-gray-600">
                            {{ $algorithm->name }}</span></div>

                    <div class="text-sm text-gray-400">{{ __('Release date') }}: <span class="text-gray-600">
                            {{ $model->release->locale('ru')->translatedFormat('F Y') }}</span></div>

                    <div x-data="{ selectedTab: 0 }" class="mt-4 md:mt-8">
                        <div
                            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                            <ul class="flex flex-wrap -mb-px">
                                @foreach ($versions as $i => $version)
                                    <li class="me-2">
                                        <a href="#" class="inline-block p-4 border-b-2 rounded-t-lg"
                                            @click="selectedTab = {{ $i }}"
                                            :class="{
                                                'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': {{ $i }} !=
                                                    selectedTab,
                                                'text-indigo-600 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-500': {{ $i }} ==
                                                    selectedTab
                                            }">
                                            {{ $version->hashrate }}{{ $version->measurement }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @foreach ($versions as $i => $version)
                            <div x-show="selectedTab == {{ $i }}">
                                @php
                                    $minPrice = $version->ads->first();
                                @endphp

                                <div class="text-sm text-gray-400 mt-6">{{ __('Efficiency') }}:
                                    <span class="text-gray-600">{{ $version->efficiency }}</span>
                                    j/{{ $version->measurement }}
                                </div>

                                <div class="text-sm text-gray-400 mt-1 sm:mt-2">{{ __('Power') }}:
                                    <span class="text-gray-600">{{ $version->efficiency * $version->hashrate }}</span>
                                    W
                                </div>

                                @if ($minPrice)
                                    <div class="text-sm text-gray-400 mt-6">{{ __('The best price') }}:
                                        @if ($hasTariff)
                                            <span class="text-gray-600">
                                                {{ $minPrice->price . ' ' . $minPrice->coin->abbreviation }}
                                            </span>
                                        @else
                                            <span class="text-gray-600 blur-sm"
                                                @click.prevent="$dispatch('open-modal', 'need-subscription')">
                                                {{ __('Subscription') }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <a class="w-max mt-6 md:mt-8"
                                        href="{{ route('ads', ['model' => strtolower(str_replace(' ', '_', $model->name)), 'asic_version_id' => $version->id]) }}">
                                        <x-primary-button>{{ __('Buy') }}</x-primary-button>
                                    </a>
                                @else
                                    <x-primary-button
                                        class="mt-4 sm:mt-6 md:mt-8 cursor-default opacity-60">{{ __('Out of stock') }}</x-primary-button>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <h3 class="text-sm font-medium text-gray-900 mt-8 mb-3">{{ __('Coins') }}</h3>

                    <div class="grid gap-2 grid-cols-3 xs:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                        @foreach ($algorithm->coins as $coin)
                            <div class="flex items-center">
                                <img src="{{ Storage::url('public/coins/' . $coin->abbreviation . '.webp') }}"
                                    alt="{{ $coin->name }}" class="w-5 sm:w-7 mr-2">
                                <div>
                                    <div class="text-xs sm:text-sm text-gray-500 mr-3">
                                        {{ $coin->abbreviation }}</div>
                                    <div class="text-xxs sm:text-xs text-gray-300 mr-3">{{ $coin->name }}
                                    </div>
                                </div>
                                {{-- <div class="text-sm text-gray-600">
                                                {{ number_format($version->hashrate * $coin->profit, 8) }}
                                            </div> --}}
                            </div>
                        @endforeach
                    </div>

                    <a class="block w-fit ml-auto mt-4 xs:mt-6 sm:mt-8"
                        href="{{ route('calculator.modelver', ['asicModel' => strtolower(str_replace(' ', '_', $model->name)), 'asicVersion' => $version->hashrate]) }}">
                        <x-secondary-button class="bg-secondary-gradient text-white">{{ __('Income calculator') }}</x-secondary-button>
                    </a>

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
