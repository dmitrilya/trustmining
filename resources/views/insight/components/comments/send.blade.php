<form action="{{ route('insight.' . $modelType . '.comment', ['channel' => $channel->slug, $modelType => $model->id]) }}"
    method="POST" x-data="{ text: '' }" @submit.prevent="addComment($el, text, null);text = ''">
    @csrf

    <div @if (!auth()->check()) @click="$dispatch('open-modal', 'login')" @endif
        class="py-2 flex items-end overflow-hidden rounded-xl border border-gray-400 dark:border-zinc-700 dark:bg-zinc-900 focus-within:ring-1 focus-within:ring-indigo-500 pr-2">
        <textarea name="text" x-model="text" rows="1" placeholder="{{ __('Your comment...') }}" x-data="{
            resize() {
                $el.style.height = '0px';
                $el.style.height = $el.scrollHeight + 'px';
            }
        }"
            x-init="resize()" @input="resize()" @readonly(!auth()->check())
            class="py-[0.125rem] min-h-7 bg-transparent border-0 resize-none focus:ring-0 text-gray-700 dark:text-gray-300 overflow-hidden w-full"></textarea>

        <button
            class="text-xs bg-gray-100 dark:bg-zinc-800 hover:bg-gray-200 hover:dark:bg-zinc-700 shadow-sm text-gray-700 dark:text-gray-300 px-3 py-1.5 rounded-full">{{ __('Send') }}</button>
    </div>
</form>
