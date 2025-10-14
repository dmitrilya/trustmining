<div class="w-full h-full flex flex-col justify-between p-2 sm:p-3 bg-white dark:bg-zinc-950 shadow-md overflow-hidden rounded-lg">
    <div
        class="w-full overflow-hidden rounded-lg overflow-hidden flex justify-center items-center mb-3 lg:mb-4">
        <svg class="w-14 h-14 text-gray-300 dark:text-gray-800" width="24" height="24" fill="currentColor"
            viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M13 10a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2H14a1 1 0 0 1-1-1Z" clip-rule="evenodd" />
            <path fill-rule="evenodd"
                d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12c0 .556-.227 1.06-.593 1.422A.999.999 0 0 1 20.5 20H4a2.002 2.002 0 0 1-2-2V6Zm6.892 12 3.833-5.356-3.99-4.322a1 1 0 0 0-1.549.097L4 12.879V6h16v9.95l-3.257-3.619a1 1 0 0 0-1.557.088L11.2 18H8.892Z"
                clip-rule="evenodd" />
        </svg>
    </div>

    <div class="flex flex-col justify-between">
        <div>
            <h6 class="text-xs xs:text-sm text-gray-800 dark:text-gray-200 font-bold">
                {{ __('Blurb') }}</h6>
            <p class="text-xxs xs:text-xs text-gray-600 dark:text-gray-400 mt-2">
                {{ __('An ad for selling equipment can be placed here. It is always at the top and attracts the attention of the resource visitor') }}
            </p>
        </div>
        <a class="block w-fit ml-auto mt-3 xs:mt-4 sm:mt-5"
            href="{{ route('support', ['chat' => 1, 'message' => __('Good day! I would like to discuss the Enterprise tariff plan')]) }}">
            <x-secondary-button class="bg-secondary-gradient !text-white">{{ __('Contact') }}</x-secondary-button>
        </a>
    </div>
</div>
