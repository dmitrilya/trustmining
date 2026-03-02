<div x-data="{
    reactions: {
        heart: {
            symbol: '❤️',
            count: {{ $comment->reactions->where('type', 'heart')->count() }},
        },
        like: {
            symbol: '👍',
            count: {{ $comment->reactions->where('type', 'like')->count() }},
        },
        dislike: {
            symbol: '👎',
            count: {{ $comment->reactions->where('type', 'dislike')->count() }}
        }
    },
    userReaction: '{{ $comment->reactions->where('user_id', auth()->id())->first()?->type }}',
    getIndex(type) {
        return Object.keys(this.reactions)
            .sort((a, b) => this.reactions[b].count - this.reactions[a].count)
            .indexOf(type);
    },
    toggleReaction(type) {
        const isAuth = {{ auth()->check() ? 'true' : 'false' }};

        if (!isAuth) {
            return $dispatch('open-modal', 'login');
        }

        const prev = this.userReaction;
        if (prev === type) {
            this.reactions[type].count--;
            this.userReaction = null;
        } else {
            if (prev) this.reactions[prev].count--;
            this.reactions[type].count++;
            this.userReaction = type;
        }
        axios.post(`/insight/comment/{{ $comment->id }}/reaction/${type}`);
    }
}" class="text-xs text-slate-500">
    <div class="flex items-center gap-3 h-5 mt-2">
        @if (!isset($withoutReply))
            <button @click="showReply = !showReply" class="hover:text-indigo-600 transition-colors"
                :class="showReply ? 'text-indigo-600' : ''">
                {{ __('Reply') }}
            </button>
        @endif

        <div class="relative flex items-center gap-1">
            <template x-for="(val, type) in reactions" :key="type">
                <button @click="toggleReaction(type)" {{-- Расчет сдвига: индекс * (ширина кнопки + gap) --}}
                    :style="'transform: translateX(' + (getIndex(type) * 44) + 'px)'"
                    :class="userReaction === type ?
                        'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 ring-1 ring-indigo-500/40' :
                        'bg-slate-200 dark:bg-slate-800 text-slate-500 hover:bg-slate-100'"
                    class="absolute left-0 flex items-center justify-center gap-0.5 px-1 py-0.5 rounded-full transition-all duration-500 ease-in-out select-none">
                    <span x-text="reactions[type].symbol"></span>
                    <span x-text="reactions[type].count" class="font-medium min-w-[10px]"></span>
                </button>
            </template>
        </div>
    </div>

    @if (!isset($withoutReply))
        <div x-show="showReply" x-transition class="mt-3">
            <form
                action="{{ route('insight.' . $modelType . '.comment', ['channel' => $channel->slug, $modelType => $model->id]) }}"
                method="POST" x-data="{ text: '' }"
                @submit.prevent="addComment($el, text, {{ $comment->id }});text = ''">
                @csrf

                <div @if (!auth()->check()) @click="$dispatch('open-modal', 'login')" @endif
                    class="py-2 flex items-end overflow-hidden rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 focus-within:ring-1 focus-within:ring-indigo-500 pr-2">
                    <textarea name="text" x-model="text" rows="1" placeholder="{{ __('Your answer...') }}" x-data="{
                        resize() {
                            $el.style.height = '0px';
                            $el.style.height = $el.scrollHeight + 'px';
                        }
                    }"
                        x-init="resize()" @input="resize()" @readonly(!auth()->check())
                        class="py-[0.125rem] min-h-7 bg-transparent border-0 resize-none focus:ring-0 overflow-hidden w-full"></textarea>

                    <button
                        class="text-base bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 hover:dark:bg-slate-700 shadow-md text-slate-700 dark:text-slate-300 min-w-7 size-7 flex items-center justify-center rounded-full">↑</button>
                </div>
            </form>
        </div>
    @endif
</div>
