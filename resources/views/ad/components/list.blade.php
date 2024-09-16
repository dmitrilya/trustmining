<div class="flex">
    <x-filter :show="true">@include('ad.components.filter')</x-filter>

    <fieldset aria-label="Choose a ad">
        <div class="grid gap-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
            @php
                $auth = Auth::user();
            @endphp

            @foreach ($ads as $ad)
                @continue((!$auth || $auth->id != $ad->user->id) && ($ad->moderation || $ad->hidden))

                @include('ad.components.card')
            @endforeach
        </div>
    </fieldset>
</div>
