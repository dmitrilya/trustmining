<x-home-layout :data="$data" :title="__('meta.wiki.algorithms.algorithm.title', ['name' => $algorithm->name])" :description="__('meta.wiki.algorithms.algorithm.description', ['name' => $algorithm->name])" :header="__('Algorithm') . ' ' . $algorithm->name">
    <x-breadcrumbs.breadcrumbs>
        <x-breadcrumbs.breadcrumb position="1" href="{{ route('wiki') }}" :name="__('meta.wiki.header')" />
        <x-breadcrumbs.breadcrumb position="2" :name="__('Algorithms')" />
        <x-breadcrumbs.breadcrumb position="3" :name="$algorithm->name" />
    </x-breadcrumbs.breadcrumbs>

    <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl p-2 sm:p-4 lg:p-6" x-data={}
        x-init="addView('algorithm', {{ $algorithm->id }})">
        <div class="text-sm text-slate-600 dark:text-slate-400 space-y-4 html-description">
            {!! $algorithm->description[app()->getLocale()] ?? ($algorithm->description['en'] ?? '') !!}
        </div>
    </div>
</x-home-layout>
