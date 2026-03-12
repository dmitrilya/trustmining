@props(['position' => 1, 'href' => '#', 'name'])

<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
    <meta itemprop="position" content="{{ $position }}" />
    <div class="flex items-center gap-1 sm:gap-2">
        <a itemprop="item" href="{{ $href }}"
            class="text-xs xs:text-sm {{ $href != '#' ? 'text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-slate-100' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200' }}">
            <span itemprop="name">{{ $name }}</span>
        </a>
        @if ($href != '#')
            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true"
                class="h-5 w-3 sm:w-4 text-slate-400">
                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
            </svg>
        @endif
    </div>
</li>
