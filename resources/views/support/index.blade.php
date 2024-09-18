<x-app-layout>
    @php
        $faqs = [
            ['q' => 'qwe', 'a' => 'tyu'],
            ['q' => 'asd', 'a' => 'ghj'],
            ['q' => 'zxc', 'a' => 'bnm'],
            ['q' => 'wer', 'a' => 'yui'],
            ['q' => 'sdf', 'a' => 'hjk'],
            ['q' => 'xcv', 'a' => 'nm,'],
            ['q' => 'ert', 'a' => 'uio'],
            ['q' => 'dfg', 'a' => 'jkl'],
            ['q' => 'cvb', 'a' => 'm,.'],
            ['q' => 'rty', 'a' => 'iop'],
            ['q' => 'fgh', 'a' => 'kl;'],
            ['q' => 'vbn', 'a' => ',./'],
        ];
    @endphp

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8" style="height: calc(100dvh - 64.4px)">
        <div
            class="w-full h-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <ul class="flex text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg dark:divide-gray-600 dark:text-gray-400 rtl:divide-x-reverse"
                id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                <li class="w-full">
                    <button id="faq-tab" data-tabs-target="#faq" type="button" role="tab" aria-controls="stats"
                        aria-selected="{{ request()->chat ? 'false' : 'true' }}"
                        class="inline-block w-full p-4 rounded-ss-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">FAQs</button>
                </li>
                <li class="w-full">
                    <button id="question-tab" data-tabs-target="#question" type="button" role="tab"
                        aria-controls="about" aria-selected="{{ request()->chat ? 'true' : 'false' }}"
                        class="inline-block w-full p-4 rounded-se-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">
                        {{ __('Your question') }}
                        @if (
                            $auth &&
                                $chat->messages->where('checked', false)->where('user_id', '!=', $auth->id)->count())
                            <span class="inline-flex w-3 h-3 bg-indigo-500 rounded-full"></span>
                        @endif
                    </button>
                </li>
            </ul>
            <div id="fullWidthTabContent" class="h-full" style="height: calc(100% - 52px)">
                <div class="h-full flex flex-col hidden p-4 md:p-6 bg-white rounded-lg dark:bg-gray-800" id="faq"
                    role="tabpanel" aria-labelledby="faq-tab" x-data="{ search: '' }">
                    <x-text-input class="w-full mb-4" @input="search = $el.value"
                        placeholder="{{ __('Search question') }}"></x-text-input>

                    <div id="accordion-flush" data-accordion="collapse"
                        class="pr-4 h-full divide-y-2 divide-gray-100 overflow-y-auto"
                        data-active-classes="bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                        data-inactive-classes="text-gray-500 dark:text-gray-400">
                        @foreach ($faqs as $faq)
                            <div
                                x-show="search === '' || '{{ $faq['q'] }}'.toLowerCase().indexOf(search) !== -1 || '{{ $faq['a'] }}'.toLowerCase().indexOf(search) !== -1">
                                <h2 id="accordion-flush-heading-{{ $loop->index }}">
                                    <button type="button"
                                        class="flex items-center justify-between w-full py-5 font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400"
                                        data-accordion-target="#accordion-flush-body-{{ $loop->index }}"
                                        aria-expanded="true" aria-controls="accordion-flush-body-{{ $loop->index }}">
                                        <span>{{ $faq['q'] }}</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </button>
                                </h2>
                                <div id="accordion-flush-body-{{ $loop->index }}" class="hidden"
                                    aria-labelledby="accordion-flush-heading-{{ $loop->index }}">
                                    <div class="py-5">
                                        <p class="text-gray-500 dark:text-gray-400">{{ $faq['a'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="h-full flex flex-col hidden bg-white rounded-lg dark:bg-gray-800 p-1 sm:p-4" id="question"
                    role="tabpanel" aria-labelledby="question-tab">
                    @if (!$auth)
                        <div class="flex items-center justify-center w-full h-full">
                            <a
                                href="{{ route('login') }}"><x-primary-button>{{ __('Sign in') }}</x-primary-button></a>
                        </div>
                    @else
                        <div class="bg-gray-100 p-1 rounded-t-md h-full overflow-hidden">
                            <div class="bg-gray-100 p-1 sm:p-5 h-full space-y-1 overflow-y-auto duration-100"
                                id="chat-messages" style="opacity: 0" x-init="setTimeout(() => {
                                    $el.scrollTo(0, $el.scrollHeight);
                                    $el.style.opacity = 1;
                                }, 100)">
                                @foreach ($chat->messages as $message)
                                    @include('chat.components.message')
                                @endforeach
                            </div>
                        </div>

                        @include('chat.components.send', ['chatId' => $chat->id])
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
