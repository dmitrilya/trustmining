<x-faqs.faqs>
    <x-faqs.faq i="1" :question="__('faq.calculator.question_1', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_1', ['b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="2" :question="__('faq.calculator.question_2', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_2', ['a' => $algorithm, 'b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="3" :question="__('faq.calculator.question_3', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_3', ['a' => $algorithm, 'b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="4" :question="__('faq.calculator.question_4', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_4', ['b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="5" :question="__('faq.calculator.question_5', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_5', [
        'b' => $selModel['b'],
        'm' => $selModel['n'],
        'p' => $selVersion['e'] * $selVersion['h'],
        'e' => $selVersion['e'] . ' j/' . $selVersion['m'],
    ])" />
    <x-faqs.faq i="6" :question="__('faq.calculator.question_6', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_6', ['b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="7" :question="__('faq.calculator.question_7', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_7', ['b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="8" :question="__('faq.calculator.question_8', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_8', ['b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="9" :question="__('faq.calculator.question_9', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_9', ['b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="10" :question="__('faq.calculator.question_10', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_10', ['b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="11" :question="__('faq.calculator.question_11', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_11', ['a' => $algorithm, 'b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="12" :question="__('faq.calculator.question_12')" :answer="__('faq.calculator.answer_12', ['b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="13" :question="__('faq.calculator.question_13', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_13', ['b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="14" :question="__('faq.calculator.question_14', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_14', ['a' => $algorithm, 'b' => $selModel['b'], 'm' => $selModel['n']])" />
</x-faqs.faqs>
