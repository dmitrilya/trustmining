<x-app-layout>
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @php
            $auth = Auth::user();
        @endphp

        @if (isset($moderation) && $auth && in_array($auth->role->name, ['admin', 'moderator']))
            @include('moderation.components.buttons')

            <div class="bg-white/60 dark:bg-zinc-900/60 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6 mb-6">
                <div class="grid gap-6">
                    <img src="{{ Storage::disk('private')->temporaryUrl($moderation->data['images'][0], now()->addSeconds(2)) }}"
                        class="w-full">
                    <img src="{{ Storage::disk('private')->temporaryUrl($moderation->data['images'][1], now()->addSeconds(2)) }}"
                        class="w-full">
                    <img src="{{ Storage::disk('private')->temporaryUrl($moderation->data['images'][2], now()->addSeconds(2)) }}"
                        class="w-full">
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
