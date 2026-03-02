<x-app-layout>
    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        @php
            $auth = Auth::user();
        @endphp

        @if (isset($moderation) && $auth && in_array($auth->role->name, ['admin', 'moderator']))
            @include('moderation.components.buttons')

            <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6 mb-6">
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
