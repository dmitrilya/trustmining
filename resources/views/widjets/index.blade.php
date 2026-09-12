<x-app-layout :title="__('meta.widjets.title')" :description="__('meta.widjets.description')">
    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8 space-y-8 lg:space-y-12">
        @include('widjets.calculator')

        @include('widjets.difficulty')
    </div>
</x-app-layout>
