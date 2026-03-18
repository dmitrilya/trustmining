<x-faqs>
    <x-faq i="1" :question="__('faq.profitable.question_1')" :answer="__('faq.profitable.answer_1')" />
    <x-faq i="2" :question="__('faq.profitable.question_2')" :answer="__('faq.profitable.answer_2')" />
    <x-faq i="3" :question="__('faq.profitable.question_3', ['y' => now()->year])" :answer="__('faq.profitable.answer_3', ['y' => now()->year])" />
    <x-faq i="4" :question="__('faq.profitable.question_4')" :answer="__('faq.profitable.answer_4')" />
    <x-faq i="5" :question="__('faq.profitable.question_5')" :answer="__('faq.profitable.answer_5')" />
</x-faqs>
