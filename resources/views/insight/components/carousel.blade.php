<div class="relative max-w-full overflow-hidden select-none" x-data="{
    isDown: false,
    startX: 0,
    scrollLeft: 0,
    walk: 0,
    handleDown(e) {
        this.isDown = true;
        const pageX = e.pageX || e.touches[0].pageX;
        this.startX = pageX - $refs.container.offsetLeft;
        this.scrollLeft = $refs.container.scrollLeft;

        $refs.container.style.scrollBehavior = 'auto';
        $refs.container.style.scrollSnapType = 'none';
    },
    handleMove(e) {
        if (!this.isDown) return;
        const pageX = e.pageX || e.touches[0].pageX;
        const x = pageX - $refs.container.offsetLeft;
        this.walk = (x - this.startX) * 1.2;
        $refs.container.scrollLeft = this.scrollLeft - this.walk;
    },
    handleUp() {
        if (!this.isDown) return;
        this.isDown = false;

        const container = $refs.container;
        const card = container.firstElementChild;
        if (!card) return;

        const style = window.getComputedStyle(card);
        const marginRight = parseInt(style.marginRight) || 0;
        const cardFullWidth = card.offsetWidth + marginRight;

        const currentScroll = container.scrollLeft;

        let targetIndex;
        if (Math.abs(this.walk) > 20) targetIndex = this.walk > 0 ? Math.floor(currentScroll / cardFullWidth) : Math.ceil(currentScroll / cardFullWidth);
        else targetIndex = Math.round(currentScroll / cardFullWidth);

        targetScroll = Math.max(0, Math.min(targetIndex * cardFullWidth, container.scrollWidth - container.clientWidth));

        container.style.scrollBehavior = 'smooth';

        if (Math.abs(container.scrollLeft - targetScroll) < 1) container.style.scrollSnapType = 'x mandatory';
        else {
            container.scrollTo({ left: targetScroll });

            const enableSnap = () => {
                container.style.scrollSnapType = 'x mandatory';
                container.removeEventListener('scrollend', enableSnap);
            };

            if ('onscrollend' in window) container.addEventListener('scrollend', enableSnap);
            else setTimeout(enableSnap, 300);
        }

        this.walk = 0;
    }
}" @mousedown="handleDown"
    @touchstart="handleDown" @mouseleave="handleUp" @mouseup="handleUp" @touchend="handleUp" @mousemove.window="handleMove"
    @touchmove="handleMove">

    <div x-ref="container"
        class="flex items-center overflow-x-auto scroll-smooth no-scrollbar cursor-grab active:cursor-grabbing snap-x snap-mandatory"
        style="scrollbar-width: none; -ms-overflow-style: none; touch-action: pan-y; scroll-snap-stop: always;">

        @foreach ($items as $item)
            <div draggable="false"
                class="shrink-0 snap-start mr-2 sm:mr-4 w-[calc(100%-1.4rem)] xs:w-[calc(50%-1rem)] sm:w-[calc(50%-1.6rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(50%-1.7rem)] xl:w-[calc(33.333%-1.5rem)]">
                @include($blade, [$model => $item])
            </div>
        @endforeach
    </div>
</div>
