<x-faqs.faqs>
    <x-faqs.faq i="1" :question="__('faq.calculator.question_1', ['m' => $selModel['n']])" :answer="__('faq.calculator.answer_1', ['a' => $algorithm, 'b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="2" :question="__('faq.calculator.question_2')" :answer="__('faq.calculator.answer_2', ['p' => $selVersion['e'] * $selVersion['h']])" />
    <x-faqs.faq i="3" :question="__('faq.calculator.question_3')" :answer="__('faq.calculator.answer_3', ['b' => $selModel['b'], 'm' => $selModel['n']])" />
    <x-faqs.faq i="4" :question="__('faq.calculator.question_4', ['b' => $selModel['b'], 'm' => $selModel['n'], 'v' => $selVersion['h'] . $selVersion['m']])" :answer="__('faq.calculator.answer_4', ['e' => $selVersion['e'] . ' j/' . $selVersion['m'], 'p' => $selVersion['e'] * $selVersion['h'], 'v' => $selVersion['h'] . $selVersion['m'], 'a' => $algorithm])" />
    <x-faqs.faq i="5" :question="__('faq.calculator.question_5', ['m' => $selModel['n']])" :answer="__('faq.calculator.answer_5', ['b' => $selModel['b'], 'm' => $selModel['n'], 'a' => $algorithm])" />
    <x-faqs.faq i="5" :question="__('faq.calculator.question_6', ['b' => $selModel['b'], 'm' => $selModel['n']])" :answer="__('faq.calculator.answer_6', ['b' => $selModel['b'], 'm' => $selModel['n'], 'v' => $selVersion['h'] . $selVersion['m']])" />
</x-faqs.faqs>
