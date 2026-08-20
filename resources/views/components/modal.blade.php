@props(['name', 'show' => false, 'maxWidth' => '2xl', 'rounded' => 'rounded-xl'])

@php
    $maxWidth = [
        'xs' => 'sm:max-w-xs',
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth];
@endphp

<div name="{{ $name }}-modal" x-data="{ show: @js($show), showed: @js($show) }" x-init="$watch('show', value => {
    if (value) {
        document.body.classList.add('overflow-y-hidden');
        setTimeout(() => {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])';
            let first = $el.querySelector(selector);
            if (first && !first.hasAttribute('disabled')) first.focus();
        }, 50);
    } else {
        document.body.classList.remove('overflow-y-hidden');
    }
})"
    x-on:open-modal.window="if ($event.detail == '{{ $name }}') {showed = true; show = true}" x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    @keydown.tab="
        let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])';
        let focusables = [...$el.querySelectorAll(selector)].filter(el => !el.hasAttribute('disabled'));
        if (focusables.length > 0) {
            let first = focusables[0];
            let last = focusables[focusables.length - 1];
            if ($event.shiftKey && document.activeElement === first) {
                last.focus();
                $event.preventDefault();
            } else if (!$event.shiftKey && document.activeElement === last) {
                first.focus();
                $event.preventDefault();
            }
        }
    "
    x-show="show" class="fixed inset-0 overflow-y-auto px-4 sm:px-0 z-50" style="display: {{ $show ? 'block' : 'none' }};"
    :style="{ top: document.getElementById('head')?.offsetHeight + 16 + 'px' }">

    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-slate-500 dark:bg-slate-950 opacity-80"></div>
    </div>

    <template x-if="showed">
        <div x-show="show"
            class="mb-6 bg-white/80 dark:bg-slate-900/80 border border-slate-300 dark:border-slate-700 {{ $rounded }} shadow-lg shadow-logo-color transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-2 sm:translate-y-0 sm:scale-95">
            <div>
                {{ $slot }}
            </div>
        </div>
    </template>
</div>
