<x-app-layout title="Онлайн чат: диалоги">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Chats') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4">
            @if (!$chats->count())
                <p class="text-base text-gray-500">
                    {{ __("You don't have any open dialogues yet. Contact a company on the ad page or company profile.") }}
                </p>
            @else
                <ul role="list" id="chat-list">
                    @foreach ($chats as $chat)
                        @php
                            $user = $chat->users->where('id', '!=', $auth->id)->first();
                            $lastMessage = null;
                            if ($chat->messages->count()) {
                                $lastMessage = $chat->messages->reverse()->first();
                                $lastMessageContent = $lastMessage->message ? $lastMessage->message : __('Files');
                            }
                            $isUnchecked = $chat->messages
                                ->where('checked', false)
                                ->where('user_id', $user->id)
                                ->count();
                        @endphp

                        <a href="{{ route('chat', ['chat' => $chat->id]) }}" id="chat-{{ $chat->id }}"
                            class="rounded-lg hover:bg-gray-100 block p-2 xs:p-3{{ $isUnchecked ? ' bg-gray-50' : '' }}">
                            <li>
                                <div id="chat-signal-{{ $chat->id }}"
                                    class="{{ !$isUnchecked ? 'hidden ' : '' }}absolute block w-2 h-2 xs:w-3 xs:h-3 bg-red-500 border xs:border-2 border-white rounded-full top-0.5 end-0.5 xs:top-1 xs:end-1 dark:border-gray-900">
                                </div>

                                <div class="flex">
                                    @if ($user->company && !$user->company->moderation && $user->company->logo)
                                        <img class="h-6 w-6 xs:h-8 xs:w-8 mr-3 flex-none rounded-full bg-gray-50"
                                            src="{{ Storage::url($user->company->logo) }}" alt="">
                                    @endif

                                    <p class="w-full text-xs font-semibold text-gray-900">{{ $user->name }}</p>

                                    <div class="min-w-fit text-right ml-2">
                                        <p class="text-xxs text-gray-900">
                                            {{ $user->company && !$user->company->moderation ? __($user->company->card['type']) : __('Person') }}
                                        </p>
                                        @if ($lastMessage)
                                            <p class="date-transform mt-0.5 xs:mt-1 text-xxs text-gray-500"
                                                data-date="{{ $lastMessage->created_at }}"></p>
                                        @endif
                                    </div>
                                </div>

                                <p class="mt-1 xs:mt-2 truncate text-xs text-gray-500 message">
                                    {{ $lastMessage ? $lastMessageContent : __('The user wanted to write you a message, but never did so') }}
                                </p>
                            </li>
                        </a>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
