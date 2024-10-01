<x-app-layout>
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8" style="height: calc(100dvh - 64.4px)">
        <div class="flex h-full">
            <div
                class="w-full max-w-xs xl:max-w-sm bg-white overflow-y-auto shadow-sm rounded-l-lg p-1 sm:p-4 h-full hidden lg:block">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach ($chats as $chat)
                        @php
                            $user = $chat->users->where('id', '!=', $auth->id)->first();
                            $lastMessage = null;
                            if ($chat->messages->count()) {
                                $lastMessage = $chat->messages->reverse()->first();
                                $lastMessageContent = $lastMessage->message ? $lastMessage->message : __('Files');
                            }
                        @endphp

                        <a href="{{ route('chat', ['chat' => $chat->id]) }}"
                            class="rounded-md hover:bg-gray-200 block p-4{{ $activeChat->id != $chat->id? ($chat->messages->where('checked', false)->where('user_id', $user->id)->count()? ' bg-gray-100': ''): ' bg-gray-200' }}">
                            <li class="flex justify-between">
                                <div class="flex min-w-0 gap-x-4">
                                    @if ($user->company && !$user->company->moderation && $user->company->logo)
                                        <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                            src="{{ Storage::url($user->company->logo) }}" alt="">
                                    @endif
                                    <div class="min-w-0 flex-auto mr-6">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">
                                            {{ $user->name }}</p>
                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                            {{ $lastMessage ? $lastMessageContent : __('The client wanted to write you a message, but never did so') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">
                                        {{ $user->company && !$user->company->moderation ? __('Company') : __('Person') }}
                                    </p>
                                    @if ($lastMessage)
                                        <p class="date-transform mt-1 text-xs leading-5 text-gray-500"
                                            data-date="{{ $lastMessage->created_at }}""></p>
                                    @endif
                                </div>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>

            <div class="w-full bg-white shadow-sm rounded-lg lg:rounded-l-none flex flex-col p-1 sm:p-4 h-full">
                @php
                    $user = $activeChat
                        ->users()
                        ->where('id', '!=', $auth->id)
                        ->first();
                @endphp

                <div class="lg:hidden px-3 py-2 sm:px-7">
                    <p class="text-md font-semibold leading-6 text-gray-900">
                        {{ $user->name }}</p>
                </div>

                <div class="bg-gray-100 p-1 rounded-t-md h-full overflow-hidden">
                    <div class="bg-gray-100 p-1 sm:p-5 h-full space-y-1 overflow-x-hidden overflow-y-auto duration-100"
                        id="chat-messages" style="opacity: 0" x-init="setTimeout(() => {
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
