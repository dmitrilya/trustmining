<x-dropdown align="bottom" width="auto">
    <x-slot name="trigger">
        <button type="button" data-dropdown-placement="top"
            class="min-w-6 h-6 sm:min-w-7 sm:h-7 flex justify-center items-center rounded-full bg-gray-200 dark:bg-zinc-700">
            <span>&#128516</span>
            <span class="sr-only">Add emoji</span>
        </button>
    </x-slot>

    <x-slot name="content">
        <div class="px-2 py-1 grid grid-cols-5 h-60 overflow-y-auto emoji-container"
            @click="e => {if (e.target.classList.contains('chat-emoji')) insertEmoji(range, $refs.editor, e.target.innerHTML);}">
            @include('chat.components.emoji')
        </div>
    </x-slot>
</x-dropdown>
