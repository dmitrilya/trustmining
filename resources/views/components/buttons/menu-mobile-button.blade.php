@props(['block' => null, 'href' => null])

<div class="flex items-center h-full"
    @if ($block) @click.stop="closeAllExcept('open{{ $block }}'); opened{{ $block }} = true; open{{ $block }} = !open{{ $block }}" @endif>
    @if ($block)
        <button
            class="w-full text-left -mx-3 sm:-mx-5 pl-2 sm:pl-4 py-2 text-sm whitespace-nowrap text-slate-800 dark:text-slate-200 border-l-4 hover:border-indigo-500 transition ease-in-out duration-300"
            :class="{
                'border-indigo-500': open{{ $block }},
                'border-transparent': !open{{ $block }}
            }">
            {{ $slot }}
        </button>
    @elseif ($href)
        <a href="{{ $href }}"
            class="w-full -mx-3 sm:-mx-5 pl-2 sm:pl-4 py-2 text-sm whitespace-nowrap text-slate-800 dark:text-slate-200 border-l-4 border-transparent hover:border-indigo-500 transition ease-in-out duration-300">
            {{ $slot }}
        </a>
    @endif
</div>
