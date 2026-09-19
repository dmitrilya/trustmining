<x-home-layout :data="$data" :title="__('meta.hashrate-converter.title')" :description="__('meta.hashrate-converter.description')" :header="__('Hashrate converter')">
    <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-lg shadow-logo-color rounded-xl p-2 sm:p-4 lg:p-6"
        x-data="hashrateConverter()">
        <div class="mb-8">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">
                {{ __('Select the type of computing power:') }}
            </label>
            <div class="flex flex-wrap gap-2 p-2 bg-slate-100 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl">
                <template x-for="type in types">
                    <button type="button" @click="changeType(type.code)"
                        :class="activeType === type.code ?
                            'bg-white/40 dark:bg-slate-900/40 text-indigo-500 shadow-md' :
                            'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                        class="flex-1 text-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200">
                        <span x-text="type.name"></span>
                    </button>
                </template>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-4">
                {{ __('Enter a value in any field for instant recalculation:') }}
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 lg:gap-4">
                <template x-for="(prefix, index) in prefixes">
                    <div
                        class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-xl p-4 flex flex-col justify-between focus-within:ring-1 ring-inset focus-within:ring-indigo-500 dark:focus-within:ring-indigo-500 transition-all">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-bold text-slate-500 font-mono" x-text="getUnitLabel(prefix)"></span>
                            <span class="text-xs text-slate-500" x-text="getPrefixName(prefix)"></span>
                        </div>

                        <input type="text" :value="values[prefix]" @keydown="filterKey($event)" @paste="filterPaste($event)"
                            @input="updateFromField($event.target.value, prefix)" placeholder="0" placeholder="0"
                            class="w-full bg-transparent border-none p-0 text-slate-800 dark:text-slate-100 font-bold text-lg font-mono focus:ring-0 focus:outline-none placeholder-slate-300 dark:placeholder-slate-700">
                    </div>
                </template>
            </div>
        </div>
    </div>

    <x-faqs.faqs>
        <x-faqs.faq i="1" :question="__('faq.hashrate-converter.question_1')" :answer="__('faq.hashrate-converter.answer_1')" />
        <x-faqs.faq i="2" :question="__('faq.hashrate-converter.question_2')" :answer="__('faq.hashrate-converter.answer_2')" />
        <x-faqs.faq i="3" :question="__('faq.hashrate-converter.question_3')" :answer="__('faq.hashrate-converter.answer_3')" />
        <x-faqs.faq i="4" :question="__('faq.hashrate-converter.question_4')" :answer="__('faq.hashrate-converter.answer_4')" />
    </x-faqs.faqs>
</x-home-layout>
