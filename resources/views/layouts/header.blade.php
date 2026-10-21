<div id="head" class="sticky top-0 left-0 z-50 {{ !isset($header) ? 'h-12 lg:h-14' : 'h-22 sm:h-24 lg:h-26' }}" x-data="{
    open: false,
    openAds: false,
    openedAds: false,
    openMenu: false,
    openedMenu: false,
    openWiki: false,
    openedWiki: false,
    menuBlocks: ['openAds', 'openMenu', 'openWiki'],
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
}">
    <div class="bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border-b border-slate-300 dark:border-slate-700 w-full shadow shadow-logo-color"
        @mouseleave="closeAllExcept()">
        <div class="w-full max-w-7xl mx-auto px-3 sm:px-5 lg:px-7">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="h-10 sm:h-12">
                    {{ $header }}
                </header>
            @endif

            <x-menu.ads @mouseover="cancelClose('openAds')" @mouseleave="startClose('openAds')" @click.away="openAds = false" class="hidden lg:block" />
            <x-menu.solutions @mouseover="cancelClose('openMenu')" @mouseleave="startClose('openMenu')" @click.away="openMenu = false"
                class="hidden lg:block" />
            <x-menu.wiki @mouseover="cancelClose('openWiki')" @mouseleave="startClose('openWiki')" @click.away="openWiki = false" class="hidden lg:block" />
        </div>
    </div>
</div>
