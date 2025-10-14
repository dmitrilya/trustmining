<div class="flex flex-col md:flex-row gap-2 sm:gap-3 lg:gap-4 mb-4">
    <div class="hidden w-full p-2 sm:p-3 md:p-4 bg-white dark:bg-zinc-900 shadow-lg overflow-hidden rounded-lg md:grid grid-cols-9">
        <div
            class="col-span-3 md:col-span-4 h-full overflow-hidden rounded-lg overflow-hidden flex justify-center items-center mr-3 lg:mr-4">
            <svg class="w-14 h-14 text-gray-300 dark:text-gray-800" width="24" height="24" fill="currentColor"
                viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M13 10a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2H14a1 1 0 0 1-1-1Z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd"
                    d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12c0 .556-.227 1.06-.593 1.422A.999.999 0 0 1 20.5 20H4a2.002 2.002 0 0 1-2-2V6Zm6.892 12 3.833-5.356-3.99-4.322a1 1 0 0 0-1.549.097L4 12.879V6h16v9.95l-3.257-3.619a1 1 0 0 0-1.557.088L11.2 18H8.892Z"
                    clip-rule="evenodd" />
            </svg>
        </div>

        <div class="col-span-6 md:col-span-5 flex flex-col justify-between">
            <div>
                <h6 class="text-xs xs:text-sm lg:text-base text-gray-800 dark:text-gray-200 font-bold">
                    {{ __('Blurb') }}</h6>
                <p class="text-xxs xs:text-xs lg:text-sm text-gray-600 dark:text-gray-400 mt-2">
                    {{ __('An ad for selling equipment can be placed here. It is always at the top and attracts the attention of the resource visitor') }}
                </p>
            </div>
            <a class="block w-fit ml-auto mt-3 xs:mt-4 sm:mt-5"
                href="{{ route('support', ['chat' => 1, 'message' => __('Good day! I would like to discuss the Enterprise tariff plan')]) }}">
                <x-secondary-button class="bg-secondary-gradient !text-white">{{ __('Contact') }}</x-secondary-button>
            </a>
        </div>
    </div>

    <div class="hidden w-full p-2 sm:p-3 md:p-4 bg-white dark:bg-zinc-900 shadow-lg overflow-hidden rounded-lg md:grid grid-cols-9">
        <div
            class="col-span-3 md:col-span-4 h-full overflow-hidden rounded-lg overflow-hidden flex justify-center items-center mr-3 lg:mr-4">
            <svg class="w-14 h-14 text-gray-300 dark:text-gray-800" width="24" height="24" fill="currentColor"
                viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M13 10a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2H14a1 1 0 0 1-1-1Z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd"
                    d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12c0 .556-.227 1.06-.593 1.422A.999.999 0 0 1 20.5 20H4a2.002 2.002 0 0 1-2-2V6Zm6.892 12 3.833-5.356-3.99-4.322a1 1 0 0 0-1.549.097L4 12.879V6h16v9.95l-3.257-3.619a1 1 0 0 0-1.557.088L11.2 18H8.892Z"
                    clip-rule="evenodd" />
            </svg>
        </div>

        <div class="col-span-6 md:col-span-5 flex flex-col justify-between">
            <div>
                <h6 class="text-xs xs:text-sm lg:text-base text-gray-800 dark:text-gray-200 font-bold">
                    {{ __('Blurb') }}</h6>
                <p class="text-xxs xs:text-xs lg:text-sm text-gray-600 dark:text-gray-400 mt-2">
                    {{ __('An ad for selling equipment can be placed here. It is always at the top and attracts the attention of the resource visitor') }}
                </p>
            </div>
            <a class="block w-fit ml-auto mt-3 xs:mt-4 sm:mt-5"
                href="{{ route('support', ['chat' => 1, 'message' => __('Good day! I would like to discuss the Enterprise tariff plan')]) }}">
                <x-secondary-button class="bg-secondary-gradient !text-white">{{ __('Contact') }}</x-secondary-button>
            </a>
        </div>
    </div>
</div>
