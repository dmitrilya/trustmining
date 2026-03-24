<x-faqs>
    <x-faq i="1" :question="__('faq.metrics.coin.rate.question_1', ['name' => $coin->name])" :answer="__('faq.metrics.coin.rate.answer_1', ['short' => $coin->abbreviation])" />
    <x-faq i="2" :question="__('faq.metrics.coin.rate.question_2', ['name' => $coin->name])" :answer="__('faq.metrics.coin.rate.answer_2', ['short' => $coin->abbreviation])" />
    <x-faq i="3" :question="__('faq.metrics.coin.rate.question_3', ['name' => $coin->name])" :answer="__('faq.metrics.coin.rate.answer_3', ['short' => $coin->abbreviation])" />
</x-faqs>
