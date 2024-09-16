<div class="flex justify-center items-center gap-4 mb-6">
    <x-secondary-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'accept-moderation')">{{ __('Accept') }}</x-secondary-button>

    <x-modal name="accept-moderation" focusable>
        <form method="post" action="{{ route('moderation.accept', ['moderation' => $moderation->id]) }}" class="p-6">
            @csrf
            @method('put')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Accept moderation?') }}
            </h2>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <x-primary-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'decline-moderation')">{{ __('Decline') }}</x-primary-button>

    <x-modal name="decline-moderation" focusable>
        <form method="post" action="{{ route('moderation.decline', ['moderation' => $moderation->id]) }}"
            class="p-6">
            @csrf
            @method('put')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Decline moderation?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('You must write a comment explaining why you rejected moderation.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="comment" value="{{ __('Comment') }}" class="sr-only" />
                <x-text-input id="comment" name="comment" class="mt-1 block w-3/4"
                    placeholder="{{ __('Comment') }}" />
                <x-input-error :messages="$errors->userDeletion->get('comment')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Decline') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
