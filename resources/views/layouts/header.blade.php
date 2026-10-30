<div id="head"
    class="sticky top-0 left-0 z-50 {{ !isset($header) ? 'h-12 lg:h-14' : 'h-[calc(5.5rem+var(--header-extra,0px))] sm:h-[calc(6rem+var(--header-extra,0px))] lg:h-[calc(6.5rem+var(--header-extra,0px))]' }}"
    x-data="{
        open: false,
        openAds: false,
        openedAds: false,
        openMenu: false,
        openedMenu: false,
        openWiki: false,
        openedWiki: false,
        openedSearch: false,
        openSearch: false,
        menuBlocks: ['openAds', 'openMenu', 'openWiki', 'openSearch'],
        clickedClosed: false,
    
        closeAllExcept(activeBlock) {
            this.menuBlocks.forEach(block => {
                if (block !== activeBlock) this[block] = false;
            });
        },
    
        startClose(block) {
            if (this.closeTimeout) clearTimeout(this.closeTimeout);
    
            this.closeTimeout = setTimeout(() => {
                this[block] = false;
                this.clickedClosed = false;
            }, {{ !isset($header) ? '150' : '1000' }});
        },
    
        cancelClose(block) {
            if (this.clickedClosed) return;
    
            if (this.closeTimeout) {
                clearTimeout(this.closeTimeout);
                this.closeTimeout = null;
            }
    
            this.closeAllExcept(block);
            this[block] = true;
        },
    
        toggleClick(block) {
            if (this[block]) {
                this[block] = false;
                this.clickedClosed = true;
            } else this.cancelClose(block);
        }
    }" x-init="$nextTick(() => {
        const header = $refs.pageHeader;
    
        if (!header) return;
    
        const updateHeaderHeight = () => {
            const baseHeight = parseFloat(
                getComputedStyle(header).getPropertyValue('--header-base')
            ) || 0;
    
            const extraHeight = Math.max(0, header.offsetHeight - baseHeight);
    
            $el.style.setProperty('--header-extra', `${extraHeight}px`);
        };
    
        const observer = new ResizeObserver(updateHeaderHeight);
    
        observer.observe(header);
    
        updateHeaderHeight();
    });">
    <div class="bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border-b border-slate-300 dark:border-slate-700 w-full shadow shadow-logo-color"
        @mouseleave="closeAllExcept('openSearch')">
        <div class="w-full max-w-7xl mx-auto px-3 sm:px-5 lg:px-7">
            @include('layouts.navigation')

            @if (isset($header))
                <header x-ref="pageHeader" class="min-h-10 sm:min-h-12 py-1 flex items-center [--header-base:40px] sm:[--header-base:48px]">
                    <div class="w-full min-w-0">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <x-menu.ads @mouseover="cancelClose('openAds')" @mouseleave="startClose('openAds')" @click.away="openAds = false" class="hidden lg:block" />
            <x-menu.solutions @mouseover="cancelClose('openMenu')" @mouseleave="startClose('openMenu')" @click.away="openMenu = false"
                class="hidden lg:block" />
            <x-menu.wiki @mouseover="cancelClose('openWiki')" @mouseleave="startClose('openWiki')" @click.away="openWiki = false" class="hidden lg:block" />
            <x-menu.search class="hidden lg:block mr-4" />
        </div>
    </div>
</div>
