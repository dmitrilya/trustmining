<x-app-layout :title="$guide->title" :description="$guide->subtitle">
    <x-slot name="header">
        <div class="flex items-center">
            <x-back-link :href="route('guides')"></x-back-link>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ml-3">
                {{ $guide->title }}
            </h2>
        </div>
    </x-slot>

    @php
        $user = Auth::user();
    @endphp

    @if (isset($moderation) && $user && in_array($user->role->name, ['admin', 'moderator']))
        <div class="max-w-7xl mx-auto px-2 sm:px-6 md:px-8 pt-8">
            @include('moderation.components.buttons', ['withUniqueCheck' => false])
        </div>
    @endif

    <div class="max-w-4xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div
            class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-2 sm:p-4 md:p-6 mb-6 space-y-4 sm:space-y-6 lg:space-y-8">
            <div class="flex items-center justify-between">
                <p class="date-transform text-xxs sm:text-xs font-normal text-gray-400" data-type="date"
                    data-date="{{ $guide->created_at }}"></p>

                <div class="flex items-center" x-data="{ liked: '{{ $user && $guide->likes->where('user_id', $user->id)->count() > 0 }}', likes: {{ $guide->likes->count() }} }">
                    <svg :class="{ 'block': liked, 'hidden': !liked }"
                        @if ($user) @click="liked = false; likes--; window.like('Guide', {{ $guide->id }})" @endif
                        class="w-4 h-4 text-gray-600 dark:text-white hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer"
                        aria-hidden="true" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg :class="{ 'hidden': liked, 'block': !liked }"
                        @if ($user) @click="liked = true; likes++; window.like('Guide', {{ $guide->id }})" @endif
                        class="w-4 h-4 text-gray-600 dark:text-white hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer"
                        aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M7 11c.889-.086 1.416-.543 2.156-1.057a22.323 22.323 0 0 0 3.958-5.084 1.6 1.6 0 0 1 .582-.628 1.549 1.549 0 0 1 1.466-.087c.205.095.388.233.537.406a1.64 1.64 0 0 1 .384 1.279l-1.388 4.114M7 11H4v6.5A1.5 1.5 0 0 0 5.5 19v0A1.5 1.5 0 0 0 7 17.5V11Zm6.5-1h4.915c.286 0 .372.014.626.15.254.135.472.332.637.572a1.874 1.874 0 0 1 .215 1.673l-2.098 6.4C17.538 19.52 17.368 20 16.12 20c-2.303 0-4.79-.943-6.67-1.475" />
                    </svg>

                    <p class="text-xxs sm:text-xs font-normal text-gray-400 ml-2 mr-4" x-text="likes"></p>

                    <svg class="w-4 h-4 text-gray-600 dark:text-white" aria-hidden="true" width="24" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            clip-rule="evenodd" />
                    </svg>

                    <p class="text-xxs sm:text-xs font-normal text-gray-400 ml-2">{{ $guide->views()->count() }}</p>
                </div>
            </div>
            <img src="{{ Storage::url($guide->preview) }}" alt="" class="rounded-lg w-full">

            @if (isset($moderation) && $user && in_array($user->role->name, ['admin', 'moderator']))
                <p class="text-xs sm:text-sm text-gray-500">{{ $guide->subtitle }}</p>
            @endif

            {!! $guide->guide !!}
        </div>
    </div>

    @if (isset($guides))
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 pb-8">
            <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($guides as $guide)
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
                        class="hidden {{ $classes }} bg-white shadow-md dark:shadow-zinc-800 overflow-hidden rounded-lg flex-col justify-between">
                        @include('guide.components.card')
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-app-layout>
