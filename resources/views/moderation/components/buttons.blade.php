@props(['withUniqueCheck' => false])

<div class="flex justify-center items-center gap-4 mb-6">
    <x-buttons.secondary-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'accept-moderation')">{{ __('Accept') }}</x-buttons.secondary-button>

    <x-modal name="accept-moderation" focusable>
        <form method="post" action="{{ route('moderation.accept', ['moderation' => $moderation->id]) }}" class="p-6">
            @csrf
            @method('put')

            <h2 class="text-lg text-slate-800 dark:text-slate-200">
                {{ __('Accept moderation?') }}
            </h2>

            @if ($withUniqueCheck)
                <div class="my-4">
                    <x-inputs.checkbox name="unique_content" value="unique_content" textClasses="text-slate-600 py-5">
                        {{ __('Unique content is used') }}
                    </x-inputs.checkbox>
                </div>
            @endif

            <div class="mt-6 flex justify-end">
                <x-buttons.secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-buttons.secondary-button>

                <x-buttons.primary-button class="ml-3">
                    {{ __('Confirm') }}
                </x-buttons.primary-button>
            </div>
        </form>
    </x-modal>

    <x-buttons.primary-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'decline-moderation')">{{ __('Decline') }}</x-buttons.primary-button>

    <x-modal name="decline-moderation" focusable>
        <form method="post" action="{{ route('moderation.decline', ['moderation' => $moderation->id]) }}"
            class="p-6">
            @csrf
            @method('put')

            <h2 class="text-lg text-slate-800 dark:text-slate-200">
                {{ __('Decline moderation?') }}
            </h2>

            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                {{ __('You must write a comment explaining why you rejected moderation.') }}
            </p>

            <div class="mt-6">
                <x-inputs.input-label for="comment" value="{{ __('Comment') }}" class="sr-only" />
                <x-inputs.text-input id="comment" name="comment" class="w-3/4" placeholder="{{ __('Comment') }}" />
                <x-inputs.input-error :messages="$errors->userDeletion->get('comment')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-buttons.secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-buttons.secondary-button>

                <x-buttons.danger-button class="ml-3">
                    {{ __('Decline') }}
                </x-buttons.danger-button>
            </div>
        </form>
    </x-modal>
</div>
