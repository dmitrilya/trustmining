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
            [
                'q' => 'Requirements for the seller',
                'a' =>
                    'To create ads, you must verify your identity using your passport and add at least one office or point of sale.',
            ],
            [
                'q' => 'Displaying ads to users',
                'a' =>
                    'After creating an ad, the moderation process begins. During this period, the ad will be hidden from users. You can also hide the ad on your store page. Hidden ads or ads under moderation are visible only to the owner on the store page.',
            ],
            [
                'q' => 'Moderation',
                'a' =>
                    'Creating ads or editing them in any way starts the moderation process. The moderation speed depends on the overall load and the seller active tariff. If the ad does not pass moderation, you will receive a notification explaining the reason. After that, you can edit the ad again.',
            ],
            [
                'q' => 'Editing an advertisement',
                'a' =>
                    'During the moderation process, editing is not available. A big plus of our platform is that after editing ads, they will continue to be displayed to users in their old form despite the moderation process.',
            ],
        ],
        'Balance and tariff plans' => [['q' => 'qwe', 'a' => 'asd']],
    ];
@endphp

<div class="h-full flex flex-col hidden p-4 md:p-6 bg-white rounded-b-2xl dark:bg-gray-800" id="faq" role="tabpanel"
    aria-labelledby="faq-tab" x-data="{ search: '' }">
    <x-text-input class="mb-4" @input="search = $el.value" placeholder="{{ __('Search question') }}" />

    <div id="accordion-flush-themes" data-accordion="collapse"
        class="pr-4 h-full divide-y-2 divide-gray-200 overflow-y-auto"
        data-active-classes="bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
        data-inactive-classes="text-gray-500 dark:text-gray-400">
        @foreach ($themes as $theme => $faqs)
            <div x-show="search === '' || $el.textContent.toLowerCase().indexOf(search) !== -1">
                <h2 id="accordion-flush-themes-heading-{{ $loop->index }}">
                    <button type="button"
                        class="flex items-center justify-between w-full py-5 font-semibold text-left rtl:text-right text-gray-700 dark:text-gray-400 text-lg"
                        data-accordion-target="#accordion-flush-themes-body-{{ $loop->index }}" aria-expanded="false"
                        aria-controls="accordion-flush-themes-body-{{ $loop->index }}">
                        <span>{{ __($theme) }}</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
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
                                <div x-show="search === '' || $el.textContent.toLowerCase().indexOf(search) !== -1">
                                    <h2
                                        id="accordion-flush-faqs-heading-{{ $loop->parent->index }}-{{ $loop->index }}">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-5 font-medium text-left rtl:text-right text-gray-500 dark:text-gray-400"
                                            data-accordion-target="#accordion-flush-faqs-body-{{ $loop->parent->index }}-{{ $loop->index }}"
                                            aria-expanded="false"
                                            aria-controls="accordion-flush-faqs-body-{{ $loop->parent->index }}-{{ $loop->index }}">
                                            <span>{{ __($faq['q']) }}</span>
                                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
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
