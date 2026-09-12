<x-faqs.faqs>
    <x-faqs.faq i="1" :question="__('faq.ad.question_1', [
        'm' => $ad->asicVersion->asicModel->name,
        'h' => $ad->asicVersion->hashrate . $ad->asicVersion->measurement,
        'n' => $ad->user->name,
    ])" :answer="$ad->props['Availability'] == 'In stock'
        ? __('faq.ad.answer_1_in_stock', ['c' => $ad->office->cityWhere, 'n' => $ad->user->name])
        : __('faq.ad.answer_1_preorder', ['d' => $ad->props['Waiting (days)']])" />
    <x-faqs.faq i="2" :question="__('faq.ad.question_2', ['b' => $ad->asicVersion->asicModel->asicBrand->name, 'm' => $ad->asicVersion->asicModel->name])" :answer="__('faq.ad.answer_2', ['n' => $ad->user->name])" />
    <x-faqs.faq i="3" :question="__('faq.ad.question_3', ['m' => $ad->asicVersion->asicModel->name, 'h' => $ad->asicVersion->hashrate . $ad->asicVersion->measurement])" :answer="__('faq.ad.answer_3', [
        'c' => $ad->asicVersion->asicModel->algorithm->coins()->first('name')->name,
        'p' =>
            $ad->version_data && count($ad->version_data->profits)
                ? __('faq.ad.answer_3', [
                    'm' => $ad->asicVersion->asicModel->name,
                    'h' => $ad->asicVersion->hashrate . $ad->asicVersion->measurement,
                    'p' => $ad->version_data->profits[0]['profit'],
                ])
                : '',
        'h' => route('calculator.modelver', ['asicModel' => $ad->asicVersion->asicModel->slug, 'asicVersion' => $ad->asicVersion->hashrate]),
    ])" />
    <x-faqs.faq i="4" :question="__('faq.ad.question_4', ['n' => $ad->user->name])" :answer="__('faq.ad.answer_4')" />
    @if ($ad->user->hosting && $ad->user->tariff && $ad->user->tariff->can_have_hosting && !$ad->user->hosting->moderation)
        <x-faqs.faq i="5" :question="__('faq.ad.question_5', ['n' => $ad->user->name])" :answer="__('faq.ad.answer_5', [
            'm' => $ad->asicVersion->asicModel->name,
            'a' => $ad->user->hosting->address,
            'tariff' => collect($ad->user->hosting->tariffs)->min('t'),
            'h' => route('company.hosting', ['user' => $ad->user->slug]),
            'n' => $ad->user->name,
        ])" />
    @endif
</x-faqs.faqs>
