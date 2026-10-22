<x-home-layout :data="$data" :title="$category->name() . '| TRUSTMINING'" :description="$category->caption() . '. ' . __('meta.voting.show.description')">
    <div class="flex flex-col sm:flex-row items-start justify-between gap-2 sm:gap-4 mb-4">
        <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-800 dark:text-slate-200">
            {{ $category->name() }}
        </h1>

        <div class="text-xs xs:text-sm px-4 py-2 rounded-xl bg-indigo-500/10 border border-indigo-600 text-indigo-500 uppercase tracking-widest">
            {{ now()->translatedFormat('F') }}</div>
    </div>

    <h2 class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-2">{{ $category->caption() }}</h2>

    <div class="mt-4 sm:mt-6 grid grid-cols-1 xs:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 gap-2 sm:gap-4" x-data="votingWidget('{{ route('voting.vote', $category->slug()) }}', '{{ $category->morphClass() }}', {{ collect(['Vote' => __('Vote'), 'Vote counted' => __('Vote counted'), 'Network error. Please try again' => __('Network error. Please try again')]) }})">
        @foreach ($candidates as $candidate)
            <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl p-2 sm:p-3">
                <div class="flex xs:flex-col items-center">
                    <a class="min-w-16 w-16 h-16 sm:min-w-20 sm:w-20 sm:h-20 rounded-full overflow-hidden hover:ring ring-indigo-600 mr-2 xs:mr-0 xs:mb-3"
                        href="{{ $candidate['href'] }}">
                        <img class="w-full" src="{{ Storage::url($candidate['img']) }}" alt="{{ $candidate['name'] }} image">
                    </a>
                    <div class="text-center">
                        <div class="text-xs text-slate-500">{{ $candidate['caption'] }}</div>
                        <h3 itemprop="name" class="text-slate-800 dark:text-slate-200 font-bold">{{ $candidate['name'] }}</h3>
                    </div>
                </div>

                <a target="_blank" href="{{ $candidate['href'] }}" class="mt-3 sm:mt-4 w-full">
                    <x-buttons.secondary-button class="w-full">{{ __('Details') }}</x-buttons.secondary-button>
                </a>

                <x-buttons.primary-button @click="submitVote({{ $candidate['id'] }})" class="w-full mt-2">
                    <span x-text="getButtonText({{ $candidate['id'] }})">{{ __('Vote') }}</span>
                </x-buttons.primary-button>
            </div>
        @endforeach
    </div>
</x-home-layout>
