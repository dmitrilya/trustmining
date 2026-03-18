<x-faqs>
    <x-faq i="1" :question="__('faq.metrics.network.hashrate.question_1', ['name' => $coin->name])" :answer="__('faq.metrics.network.hashrate.answer_1', ['name' => $coin->name, 'short' => $coin->abbreviation])" />
    <x-faq i="2" :question="__('faq.metrics.network.hashrate.question_2', ['short' => $coin->abbreviation])" :answer="__('faq.metrics.network.hashrate.answer_2', ['name' => $coin->name])" />
    <x-faq i="3" :question="__('faq.metrics.network.hashrate.question_3', ['name' => $coin->name])" :answer="__('faq.metrics.network.hashrate.answer_3', ['name' => $coin->name, 'short' => $coin->abbreviation])" />
    <x-faq i="4" :question="__('faq.metrics.network.hashrate.question_4', ['short' => $coin->abbreviation])" :answer="__('faq.metrics.network.hashrate.answer_4', ['name' => $coin->name, 'short' => $coin->abbreviation])" />
</x-faqs>
