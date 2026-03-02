@props(['path', 'name'])

<div {{ $attributes->merge(['class' => 'bg-slate-100 dark:bg-slate-800 p-3 rounded-lg']) }}>
    <div class="flex items-center">
        <div class="rounded-md overflow-hidden min-w-14 w-14 h-14 mr-4 bg-white dark:bg-slate-950 flex items-center justify-center">
            <svg class="w-7 h-7 text-slate-600 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 16 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 17V2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M5 15V1m8 18v-4">
                </path>
            </svg>
        </div>

        <div class="grow min-w-0">
            <div class="text-slate-950 dark:text-slate-100 font-semibold mb-1 truncate">{{ $name }}</div>

            <div class="flex">
                {{-- <a class="hover:underline text-slate-600 mr-4" target="_blank"
                    href="{{ route('document', ['path' => $path]) }}">
                    {{ __('Open') }}
                </a> --}}

                <a class="hover:underline text-slate-600" download href="{{ Storage::url($path) }}">
                    {{ __('Download') }}
                </a>
            </div>
        </div>
    </div>
</div>
