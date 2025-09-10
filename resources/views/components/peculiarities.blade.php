@props(['model' => 'office', 'ps' => [], 'isForm' => false])

@php
    switch ($model) {
        case 'office':
            $peculiarities = ['Free parking', 'Paid parking', 'Ability to check miner', 'Repair service'];
            break;
            case 'hosting':
            $peculiarities = ['Possibility of visiting the territory', 'Postpay', 'Payment with VAT possible'];
            break;
        
        default:
            $peculiarities = [];
            break;
    }
@endphp

<div {{ $attributes->merge(['class' => 'space-y-1.5 sm:space-y-2']) }}>
    @foreach ($peculiarities as $peculiarity)
        <x-checkbox name="peculiarities[]" :checked="in_array($peculiarity, $ps)" :disabled="!$isForm || Route::current()->getName() == 'services' && $peculiarity == 'Repair service'"
            value="{{ $peculiarity }}">{{ __($peculiarity) }}</x-checkbox>
    @endforeach
</div>
