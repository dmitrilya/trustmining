<div itemprop="author" itemscope itemtype="https://schema.org/Person" class="mb-2 sm:mb-4{{ isset($sm) ? '' : ' lg:mb-6' }} flex items-center">
    <div
        class="{{ isset($sm) ? 'size-8 sm:size-10 lg:size-12' : 'size-12 sm:size-14 lg:size-16 lg:mr-4' }} mr-2 sm:mr-3 rounded-full border border-indigo-500 p-0.5 overflow-hidden">
        <img itemprop="image" src="{{ Storage::disk('public')->exists('forum/avatar_' . $id . '.webp') ? Storage::url('public/forum/avatar_' . $id . '.webp') : Storage::url('public/forum/avatar_0.webp') }}" alt="{{ $name }}"
            class="w-full rounded-full">
    </div>

    <div>
        <h4 itemprop="name" class="{{ isset($sm) ? 'mb-0.5 sm:mb-1 lg:text-sm' : 'mb-1 sm:mb-1.5 sm:text-sm lg:text-base' }} text-xs text-gray-700 dark:text-gray-300 font-bold">
            {{ $name }}</h4>
        <div class="flex items-center xs:mb-0.5">
            <svg class="size-4 sm:size-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="m7.171 12.906-2.153 6.411 2.672-.89 1.568 2.34 1.825-5.183m5.73-2.678 2.154 6.411-2.673-.89-1.568 2.34-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.681 1.681 0 0 1 2.64 0 1.68 1.68 0 0 0 1.515.628 1.681 1.681 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.681 1.681 0 0 1 0 2.639 1.682 1.682 0 0 0-.628 1.515 1.681 1.681 0 0 1-1.866 1.866 1.681 1.681 0 0 0-1.516.628 1.681 1.681 0 0 1-2.639 0 1.681 1.681 0 0 0-1.515-.628 1.681 1.681 0 0 1-1.867-1.866 1.681 1.681 0 0 0-.627-1.515 1.681 1.681 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.681 1.681 0 0 1 9.165 4.3ZM14 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
            </svg>

            <div class="ml-1 sm:ml-2 text-xxs xs:text-xs{{ isset($sm) ? '' : ' lg:text-sm' }} text-gray-500">{{ __($status) }}</div>
        </div>
        <div class="flex items-center">
            <svg class="size-4 sm:size-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M16 10.5h.01m-4.01 0h.01M8 10.5h.01M5 5h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-6.6a1 1 0 0 0-.69.275l-2.866 2.723A.5.5 0 0 1 8 18.635V17a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
            </svg>

            <div class="ml-1 sm:ml-2 text-xxs xs:text-xs{{ isset($sm) ? '' : ' lg:text-sm' }} text-gray-500">{{ $messages }}</div>
        </div>
    </div>
</div>
