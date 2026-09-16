<x-home-layout :data="$data" :title="__('dictionary.' . $category->name . '.terms.' . $term->name . '.title')" :description="__('dictionary.' . $category->name . '.terms.' . $term->name . '.description')" :header="__('dictionary.' . $category->name . '.terms.' . $term->name . '.name')">
    <x-breadcrumbs.breadcrumbs>
        <x-breadcrumbs.breadcrumb position="1" href="{{ route('wiki') }}" :name="__('meta.wiki.header')" />
        <x-breadcrumbs.breadcrumb position="2" href="{{ route('dictionary') }}" :name="__('Crypto dictionary')" />
        <x-breadcrumbs.breadcrumb position="3" href="{{ route('dictionary.category', ['dictionaryCategory' => $category->name]) }}" :name="__('dictionary.' . $category->name . '.name')" />
        <x-breadcrumbs.breadcrumb position="4" :name="__('dictionary.' . $category->name . '.terms.' . $term->name . '.name')" />
    </x-breadcrumbs.breadcrumbs>

    <script>
        window.terms = @json($terms);
    </script>

    <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl p-2 sm:p-4 lg:p-6" x-data={}
        x-init="axios.post('/view/store', { viewable_type: 'term', viewable_id: {{ $term->id }} })">
        <style>
            h3 {
                font-size: 16px;
                font-weight: bold;
                color: rgb(30 41 59);
            }

            .dark h3 {
                color: rgb(226 232 240);
            }

            ul {
                margin-left: 16px;
                list-style: disc;
            }

            th {
                text-align: left;
            }

            td, th {
                padding: 4px 8px;
            }
        </style>

        <div class="text-sm text-slate-600 dark:text-slate-400 space-y-4">
            {!! __('dictionary.' . $category->name . '.terms.' . $term->name . '.definition') !!}
        </div>
    </div>
</x-home-layout>
