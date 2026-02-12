@php
    $selModel = $models->first();
    $selVersion = $rVersion
        ? $selModel->asicVersions->where('hashrate', $rVersion)->first()
        : $selModel->asicVersions->first();
    if (!$selVersion) {
        $selVersion = $selModel->asicVersions->first();
    }
@endphp

<x-app-layout :title="'Калькулятор майнинга: рассчитать доходность ' .
    ($rModel ? ($rVersion ? $rModel . ' ' . $rVersion : $rModel) : 'ASIC')" :description="'Рассчитать доход, расход, прибыль и окупаемость асиков' .
    ($rModel ? ($rVersion ? ' ' . $rModel . ' ' . $rVersion : ' ' . $rModel) : '') .
    ' в удобном калькуляторе доходности майнинга'"
    canonical="{{ route('calculator.modelver', [
        'asicModel' => strtolower(str_replace(' ', '_', $selModel->name)),
        'asicVersion' => $selVersion->hashrate,
    ]) }}">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Mining calculator') }}
        </h1>
    </x-slot>

    <div class="max-w-8xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="grid xl:grid-cols-4 gap-4 sm:gap-6 items-start">
            @include('calculator.components.calculator')

            <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-1 gap-4 md:gap-6">
                @include('calculator.components.liked')
                @include('calculator.components.difficulty')

                @php
                    $guide = App\Models\Blog\Guide::find(10000004);
                @endphp

                @if ($guide)
                    @include('guide.components.card', ['guide' => $guide])
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
