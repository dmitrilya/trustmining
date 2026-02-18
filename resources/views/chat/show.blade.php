<x-app-layout title="Онлайн чат: сообщения, диалоги" description="Диалог с пользователем на сайте TrustMining" noindex="true">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8" style="height: calc(100dvh - 64.4px)">
        <div class="flex h-full relative overflow-hidden" x-data="{ open: false }">
            <div :class="{ '-translate-x-full': !open, 'translate-x-0': open }"
                class="w-full max-w-xs xl:max-w-sm bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-y-auto lg:shadow-sm shadow-logo-color border-r dark:border-zinc-950 lg:border-0 lg:rounded-l-lg p-1 sm:p-4 h-[calc(100%-14rem)] sm:h-[calc(100%-15.5rem)] top-[2.75rem] sm:top-[3.5rem] z-10 lg:translate-x-0 ease-in duration-150 lg:h-full absolute lg:static">
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
                            class="rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-950 block p-2 xs:p-3{{ $activeChat->id != $chat->id ? ($isUnchecked ? ' bg-gray-50 dark:bg-zinc-800' : '') : ' border border-indigo-500' }}">
                            <li>
                                <div id="chat-signal-{{ $chat->id }}"
                                    class="{{ !$isUnchecked ? 'hidden ' : '' }}absolute block w-2 h-2 xs:w-3 xs:h-3 bg-red-500 border xs:border-2 border-white dark:border-zinc-950 rounded-full top-0.5 end-0.5 xs:top-1 xs:end-1">
                                </div>

                                <div class="flex">
                                    @if ($user->company && !$user->company->moderation && $user->company->logo)
                                        <img class="h-6 w-6 xs:h-8 xs:w-8 mr-3 flex-none rounded-full bg-gray-50 dark:bg-zinc-950"
                                            src="{{ Storage::url($user->company->logo) }}" alt="">
                                    @endif

                                    <p class="w-full text-xs font-semibold text-gray-950 dark:text-gray-100">{{ $user->name }}</p>

                                    <div class="min-w-fit text-right ml-2">
                                        <p class="text-xxs text-gray-950 dark:text-gray-100">
                                            {{ $user->company && !$user->company->moderation ? __($user->company->card['type']) : __('Person') }}
                                        </p>
                                        @if ($lastMessage)
                                            <p class="date-transform mt-0.5 xs:mt-1 text-xxs text-gray-600"
                                                data-date="{{ $lastMessage->created_at }}"></p>
                                        @endif
                                    </div>
                                </div>

                                <p class="mt-1 xs:mt-2 truncate text-xs leading-5 text-gray-600 message">
                                    {{ $lastMessage ? $lastMessageContent : __('The user wanted to write you a message, but never did so') }}
                                </p>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>

            <div class="w-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-sm shadow-logo-color rounded-lg lg:rounded-l-none flex flex-col p-1 sm:p-4 h-full">
                @php
                    $user = $activeChat->users()->where('id', '!=', $auth->id)->first();
                @endphp

                <div class="flex">
                    <div class="flex items-center lg:hidden p-1 -ml-1">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-1 rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-950 focus:outline-none focus:bg-gray-100 dark:focus:bg-zinc-950 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                            <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="lg:hidden px-3 py-2 sm:px-7">
                        <p class="text-base font-semibold leading-6 text-gray-950">
                            {{ $user->name }}</p>
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-zinc-950 p-1 rounded-t-md h-full overflow-hidden">
                    <div class="bg-gray-100 dark:bg-zinc-950 p-1 sm:p-5 h-full space-y-1 overflow-x-hidden overflow-y-auto duration-100"
                        id="chat-messages" data-chat_id="{{ $activeChat->id }}" style="opacity: 0"
                        x-init="setTimeout(() => {
                            scrollBottom($el);
                            $el.style.opacity = 1;
                        }, 100)">
                        @foreach ($messages as $message)
                            @include('chat.components.message')
                        @endforeach
                    </div>
                </div>

                @include('chat.components.send', ['chatId' => $activeChat->id, 'message' => null])
            </div>
        </div>
    </div>
</x-app-layout>
