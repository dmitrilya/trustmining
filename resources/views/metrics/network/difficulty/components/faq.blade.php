@php
    $article = App\Models\Insight\Content\Article::find(10000001);
    $answer1 = !$article
        ? __('faq.metrics.network.difficulty.answer_1', ['name' => $coin->name, 'short' => $coin->abbreviation])
        : __('faq.metrics.network.difficulty.answer_1', ['name' => $coin->name, 'short' => $coin->abbreviation]) .
            ' <a href="' .
            route('insight.article.show', [
                'channel' => $article->channel->slug,
                'article' => $article->id . '-' . Str::slug($article->title),
            ]) .
            '"
            class="inline text-indigo-500 hover:text-indigo-600">' .
            __('What is network difficulty?') .
            '</a>';
@endphp

<x-faqs>
    <x-faq i="1" :question="__('faq.metrics.network.difficulty.question_1', ['name' => $coin->name, 'short' => $coin->abbreviation])" :answer="$answer1" />
    <x-faq i="2" :question="__('faq.metrics.network.difficulty.question_2', ['short' => $coin->abbreviation])" :answer="__('faq.metrics.network.difficulty.answer_2', ['name' => $coin->name])" />
    <x-faq i="3" :question="__('faq.metrics.network.difficulty.question_3', ['name' => $coin->name])" :answer="__('faq.metrics.network.difficulty.answer_3', ['short' => $coin->abbreviation])" />
    <x-faq i="4" :question="__('faq.metrics.network.difficulty.question_4', ['short' => $coin->abbreviation])" :answer="__('faq.metrics.network.difficulty.answer_4', [
        'name' => $coin->name,
        'short' => $coin->abbreviation,
    ])" />
</x-faqs>
