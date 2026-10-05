<x-home-layout :data="$data" :title="__('meta.wiki.algorithms.title')" :description="__('meta.wiki.algorithms.description')" :header="__('Algorithm') . ' ' . $algorithm->name">
    <x-breadcrumbs.breadcrumbs>
        <x-breadcrumbs.breadcrumb position="1" href="{{ route('wiki') }}" :name="__('meta.wiki.header')" />
        <x-breadcrumbs.breadcrumb position="2" :name="__('Algorithms')" />
        <x-breadcrumbs.breadcrumb position="2" :name="$algorithm->name" />
    </x-breadcrumbs.breadcrumbs>

    <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-14"
        x-data={} x-init="addView('algorithm', {{ $algorithm->id }})">
        <div class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
            {{ $algorithm->description[app()->getLocale()] ?? ($algorithm->description['en'] ?? '') }}
        </div>
    </div>
</x-home-layout>
