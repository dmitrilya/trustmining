<div class="relative max-w-full overflow-hidden select-none" x-data="carousel()" @mousedown="start" @touchstart="start"
    @mousemove.window="move" @mouseup.window="end" @touchend.window="end" @mouseleave="end">

    <div x-ref="container"
        class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar cursor-grab active:cursor-grabbing">

        @foreach ($asicModels as $asicModel)
            <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" draggable="false"
                class="shrink-0 snap-start mr-2 sm:mr-4 w-[calc(100%-1.4rem)] xs:w-[calc(50%-1rem)] sm:w-[calc(50%-1.6rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(50%-1.7rem)] xl:w-[calc(33.333%-1.5rem)]">
                <meta itemprop="position" content="{{ $loop->iteration }}" />

                @include('database.asic-miners.card', [
                    'model' => $asicModel,
                    'href' => route('database.asic-miners.compare', [
                        'compareRequest' =>
                            $model->id > $asicModel->id
                                ? $asicModel->slug . '-vs-' . $model->slug
                                : $model->slug . '-vs-' . $asicModel->slug,
                    ]),
                    'buttonText' => __('Compare'),
                    'characteristics' => $characteristics ?? []
                ])
            </div>
        @endforeach
    </div>
</div>
