<x-app-layout title="Поддержка, часто задаваемые вопросы" description="Центр поддержки пользователей: ответы на часто задаваемые вопросы по покупке, настройке и ремонту майнинг-оборудования. Инструкции по работе с личным кабинетом, оплате и доставке. Получите помощь экспертов и решите любой вопрос быстро">
    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8" style="height: calc(100dvh - 104.4px)"
        x-data="{ tab: '{{ request()->tab ? request()->tab : 'chat' }}' }">
        <div
            class="w-full h-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-lg shadow-logo-color">
            <ul class="flex text-sm text-center text-slate-600 rounded-t-2xl divide-x divide-slate-200 border-b border-slate-300 dark:border-slate-700 dark:divide-slate-700 dark:text-slate-200 rtl:divide-x-reverse"
                role="tablist">
                {{-- <li class="w-full">
                    <button @click="tab = 'faq'" type="button" role="tab" aria-controls="faq"
                        :class="{ 'text-indigo-500': tab == 'faq' }"
                        class="inline-block w-full h-full p-4 rounded-ss-2xl hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none">FAQ</button>
                </li> --}}
                <li class="w-full">
                    <button @click="tab = 'chat'" type="button" role="tab" aria-controls="chat"
                        :class="{ 'text-indigo-500': tab == 'chat' }"
                        class="inline-block w-full h-full p-4 rounded-se-2xl hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none">
                        {{ __('We are in touch') }}
                        @if ($auth && $chat->messages->where('checked', false)->where('user_id', '!=', $auth->id)->count())
                            <span class="inline-flex w-3 h-3 bg-indigo-500 rounded-full"></span>
                        @endif
                    </button>
                </li>
                <li class="w-full">
                    <button @click="tab = 'video'" type="button" role="tab" aria-controls="video"
                        :class="{ 'text-indigo-500': tab == 'video' }"
                        class="inline-block w-full h-full p-4 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none">{{ __('Video instructions') }}</button>
                </li>
            </ul>

            <div id="fullWidthTabContent" style="height: calc(100% - 52px)">
                @include('support.components.faq')
                @include('support.components.video')

                <div x-show="tab == 'chat'" class="h-full flex flex-col bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-b-2xl p-1 sm:p-4"
                    role="tabpanel" aria-labelledby="question-tab">
                    @if (!$auth)
                        <div class="flex items-center justify-center w-full h-full">
                            <a href="{{ route('login') }}"><x-primary-button>{{ __('Sign in') }}</x-primary-button></a>
                        </div>
                    @else
                        <div class="bg-slate-100 dark:bg-slate-950 p-1 rounded-t-md h-full overflow-hidden">
                            <div class="bg-slate-100 dark:bg-slate-950 p-1 sm:p-5 h-full space-y-1 overflow-y-auto duration-100"
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
