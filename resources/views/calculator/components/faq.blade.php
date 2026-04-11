<x-faqs>
    <x-faq i="1" :question="__('faq.calculator.question_1', ['m' => $selModel->name])" :answer="__('faq.calculator.answer_1', ['a' => $selModel->algorithm->name, 'b' => $selModel->asicBrand->name, 'm' => $selModel->name])" />
    <x-faq i="2" :question="__('faq.calculator.question_2')" :answer="__('faq.calculator.answer_2', ['p' => $selVersion->efficiency * $selVersion->hashrate])" />
    <x-faq i="3" :question="__('faq.calculator.question_3')" :answer="__('faq.calculator.answer_3', ['b' => $selModel->asicBrand->name, 'm' => $selModel->name])" />
    <x-faq i="4" :question="__('faq.calculator.question_4', ['b' => $selModel->asicBrand->name, 'm' => $selModel->name, 'v' => $selVersion->hashrate . $selVersion->measurement])" :answer="__('faq.calculator.answer_4', ['e' => $selVersion->efficiency . ' j/' . $selVersion->measurement, 'p' => $selVersion->efficiency * $selVersion->hashrate, 'v' => $selVersion->hashrate . $selVersion->measurement, 'a' => $selModel->algorithm->name])" />
    <x-faq i="5" :question="__('faq.calculator.question_5', ['m' => $selModel->name])" :answer="__('faq.calculator.answer_5', ['b' => $selModel->asicBrand->name, 'm' => $selModel->name, 'a' => $selModel->algorithm->name])" />
    <x-faq i="5" :question="__('faq.calculator.question_6', ['b' => $selModel->asicBrand->name, 'm' => $selModel->name])" :answer="__('faq.calculator.answer_6', ['b' => $selModel->asicBrand->name, 'm' => $selModel->name, 'v' => $selVersion->hashrate . $selVersion->measurement])" />
</x-faqs>
