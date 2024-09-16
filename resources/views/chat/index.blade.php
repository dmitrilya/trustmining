<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Chats') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6">
            @if (!$chats->count())
                <p class="text-md text-gray-500">
                    {{ __("You don't have any open dialogues yet. Contact a company on the ad page or company profile.") }}
                </p>
            @else
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach ($chats as $chat)
                        @php
                            $user = $chat->users->where('id', '!=', $auth->id)->first();
                            $lastMessage = null;
                            if ($chat->messages->count()) {
                                $lastMessage = $chat->messages->reverse()->first();
                                $lastMessageContent = $lastMessage->message ? $lastMessage->message : __('Files');
                            }
                            $isUnchecked = $chat->messages->where('checked', false)->where('user_id', $user->id)->count();
                        @endphp

                        <a href="{{ route('chat', ['chat' => $chat->id]) }}"
                            class="rounded-md hover:bg-gray-200 block p-4{{ $isUnchecked ? ' bg-gray-100': '' }}">
                            <li class="flex justify-between">
                                <div class="flex min-w-0 gap-x-4 w-full">
                                    @if ($user->company && !$user->company->moderation && $user->company->logo)
                                        <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                            src="{{ Storage::url($user->company->logo) }}" alt="">
                                    @endif
                                    <div class="min-w-0 flex-auto mr-6 w-full">
                                        @if ($isUnchecked)
                                            <div id="notifications-signal"
                                                class="absolute block w-3 h-3 bg-red-500 border-2 border-white rounded-full top-1 end-1 dark:border-gray-900">
                                            </div>
                                        @endif

                                        <p class="text-sm font-semibold leading-6 text-gray-900">
                                            {{ $user->name }}</p>

                                        <div class="flex">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                                {{ $lastMessage ? $lastMessageContent : __('The user wanted to write you a message, but never did so') }}
                                            </p>

                                            @if ($lastMessage)
                                                <p class="ml-auto block date-transform mt-1 text-xs leading-5 text-gray-500 sm:hidden"
                                                    data-date="{{ $lastMessage->created_at }}">
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">
                                        {{ $user->company && !$user->company->moderation ? __('Company') : __('Person') }}</p>
                                    @if ($lastMessage)
                                        <p class="date-transform mt-1 text-xs leading-5 text-gray-500"
                                            data-date="{{ $lastMessage->created_at }}"></p>
                                    @endif
                                </div>
                            </li>
                        </a>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
