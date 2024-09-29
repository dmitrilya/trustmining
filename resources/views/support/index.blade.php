<x-app-layout>
    @php
        $themes = [
            'Creating and setting up an account' => [
                [
                    'q' => 'Registration',
                    'a' =>
                        'To create an account, you must provide your name or company name, a current email, and a secure password of at least eight characters.',
                ],
                [
                    'q' => 'Account name',
                    'a' =>
                        'The account name is displayed in each ad, on the hosting page, in the office card, and also in the address bar when the client goes to your profile. The account name can be changed in the profile settings. If the address bar does not display the transliteration of your name correctly, our support will help you fix it.',
                ],
                [
                    'q' => 'Setting up an account',
                    'a' =>
                        'After authorization, the Profile item will appear in the drop-down list in the upper right corner. On this page, you can change the data entered during registration, fill out the seller card and post your first ad.',
                ],
            ],
            'Seller card' => [
                [
                    'q' => 'Step one',
                    'a' =>
                        'First, verify your identity using your passport. Only then will all the platform features be available to you.',
                ],
                [
                    'q' => 'Step two',
                    'a' => 'Add at least one office or point of sale to open the possibility of creating ads.',
                ],
                [
                    'q' => 'Step three',
                    'a' =>
                        'Adding information about equipment placement is only available after the company (sole proprietor or LLC) has passed moderation.',
                ],
            ],
            'Creating ads and passing moderation' => [
                ['q' => 'Requirements for the seller', 'a' => 'To create ads, you must verify your identity using your passport and add at least one office or point of sale.'],
                ['q' => 'Displaying ads to users', 'a' => 'After creating an ad, the moderation process begins. During this period, the ad will be hidden from users. You can also hide the ad on your store page. Hidden ads or ads under moderation are visible only to the owner on the store page.'],
                ['q' => 'Moderation', 'a' => 'Creating ads or editing them in any way starts the moderation process. The moderation speed depends on the overall load and the seller active tariff. If the ad does not pass moderation, you will receive a notification explaining the reason. After that, you can edit the ad again.'],
                ['q' => 'Editing an advertisement', 'a' => 'During the moderation process, editing is not available. A big plus of our platform is that after editing ads, they will continue to be displayed to users in their old form despite the moderation process.'],
            ],
            'Balance and tariff plans' => [['q' => 'qwe', 'a' => 'asd']],
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
                        class="inline-block w-full p-4 rounded-ss-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">{{ __('Education') }}</button>
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

                    <div id="accordion-flush-themes" data-accordion="collapse"
                        class="pr-4 h-full divide-y-2 divide-gray-200 overflow-y-auto"
                        data-active-classes="bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                        data-inactive-classes="text-gray-500 dark:text-gray-400">
                        @foreach ($themes as $theme => $faqs)
                            <div x-show="search === '' || $el.textContent.toLowerCase().indexOf(search) !== -1">
                                <h2 id="accordion-flush-themes-heading-{{ $loop->index }}">
                                    <button type="button"
                                        class="flex items-center justify-between w-full py-5 font-semibold text-left rtl:text-right text-gray-700 dark:text-gray-400 text-lg"
                                        data-accordion-target="#accordion-flush-themes-body-{{ $loop->index }}"
                                        aria-expanded="false"
                                        aria-controls="accordion-flush-themes-body-{{ $loop->index }}">
                                        <span>{{ __($theme) }}</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </button>
                                </h2>
                                <div id="accordion-flush-themes-body-{{ $loop->index }}" class="hidden"
                                    aria-labelledby="accordion-flush-themes-heading-{{ $loop->index }}">
                                    <div class="p-5 md:px-10">
                                        <div id="accordion-flush-faqs-{{ $loop->index }}" data-accordion="collapse"
                                            class="h-full divide-y-2 divide-gray-100 overflow-y-auto"
                                            data-active-classes="bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                                            data-inactive-classes="text-gray-500 dark:text-gray-400">
                                            @foreach ($faqs as $faq)
                                                <div
                                                    x-show="search === '' || $el.textContent.toLowerCase().indexOf(search) !== -1">
                                                    <h2
                                                        id="accordion-flush-faqs-heading-{{ $loop->parent->index }}-{{ $loop->index }}">
                                                        <button type="button"
                                                            class="flex items-center justify-between w-full py-5 font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400"
                                                            data-accordion-target="#accordion-flush-faqs-body-{{ $loop->parent->index }}-{{ $loop->index }}"
                                                            aria-expanded="false"
                                                            aria-controls="accordion-flush-faqs-body-{{ $loop->parent->index }}-{{ $loop->index }}">
                                                            <span>{{ __($faq['q']) }}</span>
                                                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 10 6">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M9 5 5 1 1 5" />
                                                            </svg>
                                                        </button>
                                                    </h2>
                                                    <div id="accordion-flush-faqs-body-{{ $loop->parent->index }}-{{ $loop->index }}"
                                                        class="hidden"
                                                        aria-labelledby="accordion-flush-faqs-heading-{{ $loop->parent->index }}-{{ $loop->index }}">
                                                        <div class="py-5">
                                                            <p class="text-gray-500">
                                                                {{ __($faq['a']) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
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
