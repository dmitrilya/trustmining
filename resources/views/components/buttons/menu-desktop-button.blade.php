@props(['block' => null, 'href' => null])

<div class="flex items-center h-full"
    @if ($block) @mouseover="opened{{ $block }} = true; cancelClose('open{{ $block }}')"
    @mouseleave="startClose('open{{ $block }}')" @click.stop="opened{{ $block }} = true; open{{ $block }} = !open{{ $block }}" @endif>
    @if ($block)
        <button class="p-2 text-sm whitespace-nowrap border-b-2 text-slate-600 dark:text-slate-400 border-transparent transition ease-in-out duration-300"
            :class="{
                'text-slate-800 dark:text-slate-200 border-indigo-500': open{{ $block }},
                'text-slate-600 dark:text-slate-400 border-transparent': !open{{ $block }}
            }">
            {{ $slot }}
        </button>
    @elseif ($href)
        <a href="{{ $href }}"
            class="p-2 text-sm whitespace-nowrap border-b-2 text-slate-600 dark:text-slate-400 border-transparent hover:text-slate-800 hover:dark:text-slate-200 hover:border-indigo-500 transition ease-in-out duration-300">
            {{ $slot }}
        </a>
    @endif
</div>
