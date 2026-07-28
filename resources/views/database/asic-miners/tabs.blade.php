<div class="mt-8" x-data="{ selectedTab: window.innerWidth >= 768 ? 'description' : 'characteristics' }">
    <div class="mb-6 sm:mb-8 lg:mb-10 text-xs sm:text-sm text-center text-slate-600 border-b border-slate-300 dark:text-slate-400 dark:border-slate-800">
        <ul class="flex flex-wrap -mb-px">
            <li class="mr-0.5 sm:mr-2 md:hidden">
                <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'characteristics'"
                    :class="{
                        'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'characteristics' !=
                            selectedTab,
                        'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'characteristics' ==
                            selectedTab
                    }">
                    {{ __('Characteristics') }}
                </button>
            </li>
            <li class="mr-0.5 sm:mr-2">
                <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'description'"
                    :class="{
                        'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'description' !=
                            selectedTab,
                        'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'description' ==
                            selectedTab
                    }">
                    {{ __('Description') }}
                </button>
            </li>
            <li class="mr-0.5 sm:mr-2">
                <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'reviews'"
                    :class="{
                        'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'reviews' !=
                            selectedTab,
                        'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'reviews' ==
                            selectedTab
                    }">
                    {{ __('Reviews') }}
                </button>
            </li>
        </ul>
    </div>

    <div x-show="selectedTab == 'characteristics'" style="display: none">
        <x-characteristics.characteristics>
            <x-characteristics.characteristic name="Manufacturer" :value="$brand->name" itemprop="additionalProperty" />
            <x-characteristics.characteristic name="Algorithm" :value="$algorithms[$versions->first()['a']]['n']" itemprop="additionalProperty" />
            @if ($model->psus->count())
                <x-characteristics.characteristic name="Power connector" :value="$model->psus->first()->connector" itemprop="additionalProperty" />
            @endif
            <x-characteristics.characteristic name="Cooling" :value="$model->characteristics['Cooling']" itemprop="additionalProperty" />
            <x-characteristics.characteristic name="Release date" :value="$model->release->locale(app()->getLocale())->translatedFormat('F Y')" />
            <meta itemprop="releaseDate" content="{{ $model->release->toIso8601String() }}">
        </x-characteristics.characteristics>
    </div>

    <div x-show="selectedTab == 'description'" style="display: none">
        @include('database.asic-miners.description')
    </div>

    <div class="space-y-6" x-show="selectedTab == 'reviews'" style="display: none">
        @include('review.reviews', ['auth' => auth()->user(), 'reviews' => $model->reviews])
        @include('review.send', [
            'auth' => auth()->user(),
            'reviews' => $model->reviews,
            'type' => 'asic-model',
            'id' => $model->id,
        ])
    </div>
</div>
