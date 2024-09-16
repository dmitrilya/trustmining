<x-app-layout>
    <x-slot name="header">
        <div class="relative w-full max-w-md" x-data="{ open: false, sugs: false }" @click.away="open = false">
            <div class="relative z-0 w-full group" @click="open = true">
                <input type="text"
                    placeholder="{{ __('Find a miner, company or article...') }}"
                    @input.debounce.1000ms="sugs = search($el.value, $refs.suggestionList, open)" autocomplete="off"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-gray-800 focus:outline-none focus:ring-0 focus:border-gray-800 peer" />
            </div>

            <ul role="listbox" style="display: none" x-show="open && sugs" x-ref="suggestionList"
                class="absolute z-10 mt-1 w-full overflow-auto rounded-md bg-white text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
            </ul>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @foreach ($articles as $article)
                @php
                    switch ($loop->index) {
                        case 0:
                        case 1:
                            $classes = '!flex';
                            break;
                        case 2:
                            $classes = 'md:!flex';
                            break;
                        case 3:
                            $classes = 'lg:!flex';
                            break;
                        case 4:
                            $classes = 'xl-!flex';
                            break;
                    }
                @endphp

                <div
                    class="hidden {{ $classes }} bg-white shadow-md overflow-hidden rounded-lg flex-col justify-between">
                    @include('article.components.card')
                </div>
            @endforeach
        </div>

        @php
            $auth = Auth::user();
        @endphp

        <div class="grid gap-2 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 mt-8">
            @foreach ($ads as $ad)
                @php
                    switch ($loop->index) {
                        case 0:
                        case 1:
                            $classes = '!block';
                            break;
                        case 2:
                            $classes = 'md:!block';
                            break;
                        case 3:
                            $classes = 'lg:!block';
                            break;
                        case 4:
                            $classes = 'xl-!block';
                            break;
                    }
                @endphp

                <div class="hidden {{ $classes }} w-full h-full">
                    @include('ad.components.card')
                </div>
            @endforeach
        </div>

        <div class="grid gap-2 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 mt-8">
            @foreach ($hostings as $hosting)
                @php
                    switch ($loop->index) {
                        case 0:
                        case 1:
                            $classes = '!block';
                            break;
                        case 2:
                            $classes = 'md:!block';
                            break;
                        case 3:
                            $classes = 'lg:!block';
                            break;
                        case 4:
                            $classes = 'xl-!block';
                            break;
                    }
                @endphp

                <div class="hidden {{ $classes }} w-full h-full">
                    @include('hosting.components.card')
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
