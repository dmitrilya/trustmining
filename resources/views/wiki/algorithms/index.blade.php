<x-home-layout :data="$data" :title="__('meta.wiki.algorithms.title')" :description="__('meta.wiki.algorithms.description')" :header="__('meta.wiki.algorithms.header')">
    <x-breadcrumbs.breadcrumbs>
        <x-breadcrumbs.breadcrumb position="1" href="{{ route('wiki') }}" :name="__('meta.wiki.header')" />
        <x-breadcrumbs.breadcrumb position="2" :name="__('Algorithms')" />
    </x-breadcrumbs.breadcrumbs>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-2">
        @foreach ($algorithms as $algorithm)
            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl p-2 sm:p-3 flex flex-col justify-between">
                <div>
                    <div class="flex items-center">
                        <div class="relative w-10 mr-2">
                            @foreach ($algorithm->coins->take(2) as $coin)
                                <img alt="{{ $coin->name }} icon" class="w-5 xs:w-6 absolute -translate-y-1/2 {{ $loop->index == 0 ? 'z-10' : 'left-4' }}"
                                    src="{{ Storage::url('public/coins/' . $coin->abbreviation . '.webp') }}" />
                            @endforeach
                        </div>

                        <h3 class="font-bold sm:text-lg text-slate-800 dark:text-slate-200">
                            {{ $algorithm->name }}
                        </h3>
                    </div>

                    <div class="text-xs lg:text-sm text-slate-600 dark:text-slate-400 mt-2 sm:mt-3">{{ $algorithm->caption[app()->getLocale()] ?? $algorithm->caption['en'] ?? '' }}</div>
                </div>

                {{-- <a class="block w-fit ml-auto text-xs sm:text-sm text-indigo-500 hover:text-indigo-600"
                    href="{{ route('algorithm.show', ['algorithm' => strtolower($algorithm->name)]) }}">{{ __('Details') }}</a> --}}
            </div>
        @endforeach
    </div>
</x-home-layout>
