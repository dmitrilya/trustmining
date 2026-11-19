@props(['path', 'name'])

<div {{ $attributes->merge(['class' => 'bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 p-2 rounded-xl']) }}>
    <div class="flex items-center gap-2">
        <div class="p-2 bg-indigo-500/10 border border-indigo-600 text-indigo-500 rounded-lg">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 16 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M1 17V2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M5 15V1m8 18v-4">
                </path>
            </svg>
        </div>

        <div class="grow min-w-0">
            <div class="text-sm sm:text-base font-bold text-slate-800 dark:text-slate-200 truncate">{{ $name }}</div>

            <div class="flex">
                {{-- <a class="hover:underline text-slate-600 mr-4" target="_blank"
                    href="{{ route('document', ['path' => $path]) }}">
                    {{ __('Open') }}
                </a> --}}

                <a class="text-xs text-indigo-500 hover:text-indigo-600" download href="{{ $path }}">
                    {{ __('Download') }}
                </a>
            </div>
        </div>
    </div>
</div>
