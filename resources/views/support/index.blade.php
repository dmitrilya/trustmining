<x-app-layout title="Поддержка, часто задаваемые вопросы">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8" style="height: calc(100dvh - 64.4px)" x-data="{ tab: 0 }">
        <div
            class="w-full h-full bg-white border border-gray-200 rounded-2xl shadow-lg dark:shadow-zinc-800 dark:bg-zinc-900 dark:border-zinc-800">
            <ul class="flex text-sm text-center text-gray-600 rounded-t-2xl divide-x divide-gray-200 border-b border-gray-200 dark:border-zinc-700 dark:divide-zinc-700 dark:text-gray-200 rtl:divide-x-reverse"
                role="tablist">
                <li class="w-full">
                    <button @click="tab = 0" type="button" role="tab" aria-controls="faq"
                        aria-selected="{{ request()->chat ? 'false' : 'true' }}" :class="{ 'text-indigo-500': tab == 0 }"
                        class="inline-block w-full p-4 rounded-ss-2xl hover:bg-gray-100 dark:hover:bg-zinc-800 focus:outline-none dark:bg-zinc-900">FAQ</button>
                </li>
                <li class="w-full">
                    <button @click="tab = 1" type="button" role="tab" aria-controls="question"
                        aria-selected="{{ request()->chat ? 'true' : 'false' }}" :class="{ 'text-indigo-500': tab == 1 }"
                        class="inline-block w-full p-4 rounded-se-2xl hover:bg-gray-100 dark:hover:bg-zinc-800 focus:outline-none dark:bg-zinc-900">
                        {{ __('Your question') }}
                        @if ($auth && $chat->messages->where('checked', false)->where('user_id', '!=', $auth->id)->count())
                            <span class="inline-flex w-3 h-3 bg-indigo-500 rounded-full"></span>
                        @endif
                    </button>
                </li>
            </ul>

            <div id="fullWidthTabContent" style="height: calc(100% - 52px)">
                @include('support.components.faq')

                <div x-show="tab == 1"
                    class="h-full flex flex-col bg-white rounded-b-2xl dark:bg-zinc-900 p-1 sm:p-4"
                    role="tabpanel" aria-labelledby="question-tab">
                    @if (!$auth)
                        <div class="flex items-center justify-center w-full h-full">
                            <a href="{{ route('login') }}"><x-primary-button>{{ __('Sign in') }}</x-primary-button></a>
                        </div>
                    @else
                        <div class="bg-gray-100 dark:bg-zinc-950 p-1 rounded-t-md h-full overflow-hidden">
                            <div class="bg-gray-100 dark:bg-zinc-950 p-1 sm:p-5 h-full space-y-1 overflow-y-auto duration-100"
                                id="chat-messages" style="opacity: 0" x-init="setTimeout(() => {
                                    $el.scrollTo(0, $el.scrollHeight);
                                    $el.style.opacity = 1;
                                }, 100)">
                                @foreach ($chat->messages as $message)
                                    @include('chat.components.message')
                                @endforeach
                            </div>
                        </div>

                        @include('chat.components.send', [
                            'chatId' => $chat->id,
                            'message' => request()->message,
                        ])
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
