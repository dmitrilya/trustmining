<div class="bg-white/60 dark:bg-zinc-900/60 shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4">
    <h2
        class="mb-3 sm:mb-5 xs:text-lg sm:text-xl text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-bold">
        {{ __('Liked the calculator?') }}
    </h2>

    <x-secondary-button class="flex items-center mb-2 sm:mb-3"
        @click="navigator.clipboard.writeText(window.location.href + '?utm_source=share_button&utm_campaign=content_propagation&utm_content=calculator_page')
        .then(() => pushToastAlert('{{ __('Link successfully copied') }}', 'success'))">
        <svg class="size-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z"
                clip-rule="evenodd" />
            <path fill-rule="evenodd"
                d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z"
                clip-rule="evenodd" />
        </svg>

        {{ __('Copy link') }}
    </x-secondary-button>

    <x-primary-button class="flex items-center"
        @click="navigator.share({
                title: document.title,
                url: window.location.href + '?utm_source=share_button&utm_campaign=content_propagation&utm_content=calculator_page'
            });">
        <svg class="size-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                d="M7.926 10.898 15 7.727m-7.074 5.39L15 16.29M8 12a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm12 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm0-11a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
        </svg>

        {{ __('Share') }}
    </x-primary-button>
</div>
