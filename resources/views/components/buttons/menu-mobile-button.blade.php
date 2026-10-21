@props(['block' => null, 'href' => null])

<div class="flex items-center h-full"
    @if ($block) @click.stop="closeAllExcept('open{{ $block }}'); opened{{ $block }} = true; open{{ $block }} = !open{{ $block }}" @endif>
    @if ($block)
        <button
            class="w-full text-left -mx-3 sm:-mx-5 pl-2 sm:pl-4 py-2 text-sm whitespace-nowrap border-l-4 hover:text-slate-800 hover:dark:text-slate-200 hover:border-indigo-500 transition ease-in-out duration-300"
            :class="{
                'text-slate-800 dark:text-slate-200 border-indigo-500': open{{ $block }},
                'text-slate-600 dark:text-slate-400 border-transparent': !open{{ $block }}
            }">
            {{ $slot }}
        </button>
    @elseif ($href)
        <a href="{{ $href }}"
            class="w-full -mx-3 sm:-mx-5 pl-2 sm:pl-4 py-2 text-sm whitespace-nowrap border-l-4 text-slate-600 dark:text-slate-400 border-transparent hover:text-slate-800 hover:dark:text-slate-200 hover:border-indigo-500 transition ease-in-out duration-300">
            {{ $slot }}
        </a>
    @endif
</div>
