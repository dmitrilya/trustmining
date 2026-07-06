<section>
    <header class="mb-2">
        <div class="flex justify-between">
            <h2 class="text-lg text-slate-800 dark:text-slate-200">
                {{ __('API') }}
            </h2>

            <a href="{{ route('api.doc') }}" class="text-xs xs:text-sm text-indigo-500 hover:text-indigo-600">
                {{ __('Documentation') }}
            </a>
        </div>
    </header>

    @if (auth()->user()->tokens()->exists())
        <p class="text-sm text-slate-600 dark:text-slate-400 mb-3">
            {{ __('Token is active. In case of loss or for security purposes, you can generate a new one.') }}
        </p>
    @else
        <p class="text-sm text-slate-600 dark:text-slate-400 mb-3">
            {{ __('Generate a token to create your own integration. It will only appear once. You need to save it immediately.') }}
        </p>
    @endif

    <button
        class="block ml-auto mt-4 items-center px-4 py-2 bg-primary-gradient rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none focus:opacity-90"
        @click="axios.get('{{ route('api.token.generate') }}').then(r => {
            if (!r.data.success) window.pushToastAlert(r.data.message, 'error');
            else {
                $el.classList.add('hidden');
                $el.nextElementSibling.classList.remove('hidden');
                $el.nextElementSibling.value = r.data.token;
            }
        })">
        {{ __('Generate') }}
    </button>

    <x-text-input class="hidden mt-4    "></x-text-input>
</section>
