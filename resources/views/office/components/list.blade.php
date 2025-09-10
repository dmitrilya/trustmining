<x-filter>@include('office.components.filter')</x-filter>

@if (!$offices->count())
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6">
        <p class="text-base text-gray-500">
            {{ __('There is no information about open offices and points of sale.') }}
        </p>
    </div>
@else
    <fieldset aria-label="Choose an office" class="w-full">
        <ul role="list" class="divide-y divide-gray-100">
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-1 xl:grid-cols-2 gap-2">
                @foreach ($offices as $office)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6">
                        @include('office.components.card')
                    </div>
                @endforeach
            </div>
        </ul>
    </fieldset>
@endif
