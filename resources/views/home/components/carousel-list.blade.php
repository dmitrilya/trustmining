@foreach ($items as $item)
    <div draggable="false"
        class="shrink-0 snap-start mr-2 sm:mr-4 w-[calc(100%-1.4rem)] xs:w-[calc(50%-1rem)] sm:w-[calc(50%-1.6rem)] md:w-[calc(33.333%-1.5rem)] {{ !isset($bigWrapper) ? 'lg:w-[calc(50%-1.7rem)] xl:w-[calc(33.333%-1.5rem)]' : 'xl:w-[calc(25%-1.5rem)]' }}">

        @include($blade, [$model => $item, 'owner' => false, 'user' => auth()->user()])
    </div>
@endforeach
