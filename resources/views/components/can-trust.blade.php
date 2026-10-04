@props(['user', 'id'])

@php
    $offices = $user->offices;
    $company = $user->company;
    
    if ($company) {
        $registration = \Carbon\Carbon::createFromTimestamp($company->card['registration_date']);
        
        $years = (int) $registration->diffInYears(now(), false); 
        $employers = (int) ($company->card['employee_count'] ?? 0);
        
        $companyType = $company->card['type'] === 'LEGAL' ? 'llc' : 'ip';
        $formattedDate = $registration->translatedFormat('d F Y');
    }
    
    $tf = $user->tf;
    $greenLimit = config('trustfactor.green');
    $yellowLimit = config('trustfactor.yellow');
@endphp

<div class="mb-8">
    <h2 class="font-extrabold tracking-tight text-slate-800 dark:text-slate-200">
        {{ __('Can you trust') }} {{ $user->name }}?
    </h2>

    <div itemprop="description" class="mt-5 text-xs xs:text-sm sm:text-base text-slate-600 dark:text-slate-400">
        
        @if ($tf > $greenLimit)
            <p>{{ __('descriptions.can_trust.trust.green', ['seller' => $user->name]) }}</p>
        @convertRows
        @elseif ($tf > $yellowLimit)
            <p>{{ __('descriptions.can_trust.trust.yellow', ['seller' => $user->name]) }}</p>
        @else
            <p>{{ __('descriptions.can_trust.trust.red', ['seller' => $user->name]) }}</p>
        @endif
        <br>

        @if (!$company)
            @if ($tf <= $yellowLimit)
                <p>{{ __('descriptions.can_trust.company.person') }}</p>
            @endif
        @else
            @if ($tf > $yellowLimit || ($tf <= $yellowLimit && $years < 1))
                <p>{{ __("descriptions.can_trust.company.{$companyType}", ['name' => $company->name, 'registration' => $formattedDate]) }}</p>
            @endif

            @if ($tf > $greenLimit)
                @if ($years > 4)
                    <p>{{ __('descriptions.can_trust.company.registration.>4') }}</p>
                @elseif ($years > 2)
                    <p>{{ __('descriptions.can_trust.company.registration.2-4') }}</p>
                @endif
            @elseif ($tf > $yellowLimit)
                @if ($years < 1)
                    <p>{{ __('descriptions.can_trust.company.registration.<1') }}</p>
                @elseif ($years > 2 && $years < 4)
                    <p>{{ __('descriptions.can_trust.company.registration.2-4') }}</p>
                @endif
            @else
                @if ($years < 1)
                    <p>{{ __('descriptions.can_trust.company.registration.<1') }}</p>
                @endif
            @endif

            @if (!$employers)
                @if ($tf <= $yellowLimit)
                    <p>{{ __('descriptions.can_trust.company.employers.not', ['seller' => $user->name]) }}</p>
                    @if ($years < 2)
                        <p>{{ __('descriptions.can_trust.company.employers.registration') }}</p>
                    @endif
                @endif
            @else
                @if (($tf > $greenLimit && $employers > 4) || ($tf > $yellowLimit && $employers <= 10) || ($tf <= $yellowLimit && $employers <= 4))
                    <p>{{ trans_choice('descriptions.can_trust.company.employers.have', $employers, ['seller' => $user->name, 'count' => $employers]) }}</p>
                @endif

                @if ($tf > $greenLimit && $employers > 4)
                    <p>{{ $employers > 10 ? __('descriptions.can_trust.company.employers.>10') : __('descriptions.can_trust.company.employers.4-10') }}</p>
                @elseif ($tf > $yellowLimit && $employers <= 10)
                    <p>{{ $employers > 4 ? __('descriptions.can_trust.company.employers.4-10') : __('descriptions.can_trust.company.employers.1-4') }}</p>
                    @if ($employers <= 4 && $years < 2)
                        <p>{{ __('descriptions.can_trust.company.employers.registration') }}</p>
                    @endif
                @elseif ($tf <= $yellowLimit && $employers <= 4)
                    <p>{{ __('descriptions.can_trust.company.employers.1-4') }}</p>
                    @if ($years < 2)
                        <p>{{ __('descriptions.can_trust.company.employers.registration') }}</p>
                    @endif
                @endif
            @endif
        @endif

        @if ($tf > $greenLimit && $offices->count() > 1)
            <p>{{ __('descriptions.can_trust.offices.many', ['count' => $offices->count()]) }}</p>
        @elseif ($tf <= $greenLimit && $offices->count() == 1)
            <p>{{ __('descriptions.can_trust.offices.one', ['city' => $offices->first()->city]) }}</p>
        @endif

        <br>
        <p>{{ __('descriptions.can_trust.conclusion')[$id % 4] }}</p>
    </div>
</div>
