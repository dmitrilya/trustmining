<div class="flex">
    <x-filter :show="true">@include('hosting.components.filter')</x-filter>

    <fieldset aria-label="Choose a ad" class="w-full">
        <div class="grid gap-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
            @php
                $auth = Auth::user();
            @endphp

            @foreach ($hostings as $hosting)
                @continue((!$auth || $auth->id != $hosting->user->id) && $hosting->moderation)

                @include('hosting.components.card')
            @endforeach
        </div>
    </fieldset>
</div>
