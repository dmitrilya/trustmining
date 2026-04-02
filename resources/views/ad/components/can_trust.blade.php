<div class="mt-8">
    <h2 class="font-bold tracking-tight text-slate-800 dark:text-slate-200">
        {{ __('Can I trust the seller') }} {{ $ad->user->name }}?</h2>

    <div itemprop="description"
        class="mt-5 text-xxs xs:text-xs sm:text-sm sm:text-base text-slate-600 dark:text-slate-400">
        {{-- GREEN --}}
        @php
            $offices = $ad->user->offices;
        @endphp

        @if ($user->tf > config('trustfactor.green'))
            <p>{{ __('descriptions.can_trust.trust.green', ['seller' => $ad->user->name]) }}</p>
            <br>
            @if ($ad->user->company)
                @php
                    $registration = Carbon\Carbon::createFromTimestampMs(
                        $ad->user->company->card['state']['registration_date'],
                    );
                    $years = Carbon\Carbon::now()->diffInYears($registration);
                    $employers = $ad->user->company->card['employee_count'] ?? 0;
                @endphp

                @if ($ad->user->company->card['type'] == 'LEGAL')
                    <p>{{ __('descriptions.can_trust.company.llc', ['name' => $ad->user->company->name, 'registration' => $registration->translatedFormat('d F Y')]) }}
                    </p>
                @else
                    <p>{{ __('descriptions.can_trust.company.ip', ['name' => $ad->user->company->name, 'registration' => $registration->translatedFormat('d F Y')]) }}
                    </p>
                @endif

                @if ($years > 4)
                    <p>{{ __('descriptions.can_trust.company.registration.>4') }}</p>
                @elseif ($years > 2)
                    <p>{{ __('descriptions.can_trust.company.registration.2-4') }}</p>
                @endif

                @if ($employers > 4)
                    <p>{{ trans_choice('descriptions.can_trust.company.employers.have', $employers, ['seller' => $ad->user->name, 'count' => $employers]) }}
                    </p>
                    @if ($employers > 10)
                        <p>{{ __('descriptions.can_trust.company.employers.>10') }}</p>
                    @else
                        <p>{{ __('descriptions.can_trust.company.employers.4-10') }}</p>
                    @endif
                @endif
            @endif

            @if ($offices->count() == 1)
                <p>{{ __('descriptions.can_trust.company.offices.one') }}</p>
            @endif
            {{-- YELLOW --}}
        @elseif ($user->tf > config('trustfactor.yellow'))
            <p>{{ __('descriptions.can_trust.trust.yellow', ['seller' => $ad->user->name]) }}</p>
            <br>
            @if (!$ad->user->company)
                <p>{{ __('descriptions.can_trust.company.person') }}</p>
            @else
                @php
                    $registration = Carbon\Carbon::createFromTimestampMs(
                        $ad->user->company->card['state']['registration_date'],
                    );
                    $years = Carbon\Carbon::now()->diffInYears($registration);
                    $employers = $ad->user->company->card['employee_count'] ?? 0;
                @endphp

                @if ($ad->user->company->card['type'] == 'LEGAL')
                    <p>{{ __('descriptions.can_trust.company.llc', ['name' => $ad->user->company->name, 'registration' => $registration->translatedFormat('d F Y')]) }}
                    </p>
                @else
                    <p>{{ __('descriptions.can_trust.company.ip', ['name' => $ad->user->company->name, 'registration' => $registration->translatedFormat('d F Y')]) }}
                    </p>
                @endif

                @if ($years < 1)
                    <p>{{ __('descriptions.can_trust.company.registration.<1') }}</p>
                @elseif ($years > 2 && $years < 4)
                    <p>{{ __('descriptions.can_trust.company.registration.2-4') }}</p>
                @endif

                @if (!$employers)
                    <p>{{ __('descriptions.can_trust.company.employers.not', ['seller' => $ad->user->name]) }}</p>
                    @if ($years < 2)
                        <p>{{ __('descriptions.can_trust.company.employers.registration') }}</p>
                    @endif
                @elseif ($employers <= 10)
                    <p>{{ trans_choice('descriptions.can_trust.company.employers.have', $employers, ['seller' => $ad->user->name, 'count' => $employers]) }}
                    </p>
                    @if ($employers > 4)
                        <p>{{ __('descriptions.can_trust.company.employers.4-10') }}</p>
                    @else
                        <p>{{ __('descriptions.can_trust.company.employers.1-4') }}</p>
                        @if ($years < 2)
                            <p>{{ __('descriptions.can_trust.company.employers.registration') }}</p>
                        @endif
                    @endif
                @endif
            @endif

            @if ($offices->count() == 1)
                <p>{{ __('descriptions.can_trust.company.offices.one') }}</p>
            @endif
            {{-- RED --}}
        @else
            <p>{{ __('descriptions.can_trust.trust.red', ['seller' => $ad->user->name]) }}</p>
            <br>
            @if (!$ad->user->company)
                <p>{{ __('descriptions.can_trust.company.person') }}</p>
            @else
                @php
                    $registration = Carbon\Carbon::createFromTimestampMs(
                        $ad->user->company->card['state']['registration_date'],
                    );
                    $years = Carbon\Carbon::now()->diffInYears($registration);
                    $employers = $ad->user->company->card['employee_count'] ?? 0;
                @endphp

                @if ($years < 1)
                    @if ($ad->user->company->card['type'] == 'LEGAL')
                        <p>{{ __('descriptions.can_trust.company.llc', ['name' => $ad->user->company->name, 'registration' => $registration->translatedFormat('d F Y')]) }}
                        </p>
                    @else
                        <p>{{ __('descriptions.can_trust.company.ip', ['name' => $ad->user->company->name, 'registration' => $registration->translatedFormat('d F Y')]) }}
                        </p>
                    @endif
                    <p>{{ __('descriptions.can_trust.company.registration.<1') }}</p>
                @endif

                @if (!$employers)
                    <p>{{ __('descriptions.can_trust.company.employers.not', ['seller' => $ad->user->name]) }}</p>
                    @if ($years < 2)
                        <p>{{ __('descriptions.can_trust.company.employers.registration') }}</p>
                    @endif
                @elseif ($employers <= 4)
                    <p>{{ trans_choice('descriptions.can_trust.company.employers.have', $employers, ['seller' => $ad->user->name, 'count' => $employers]) }}
                    </p>
                    <p>{{ __('descriptions.can_trust.company.employers.1-4') }}</p>
                    @if ($years < 2)
                        <p>{{ __('descriptions.can_trust.company.employers.registration') }}</p>
                    @endif
                @endif
            @endif

            @if ($offices->count() == 1)
                <p>{{ __('descriptions.can_trust.company.offices.one') }}</p>
            @endif
        @endif
        <br>
        <p>{{ __('descriptions.can_trust.conclusion') }}</p>
    </div>
</div>
