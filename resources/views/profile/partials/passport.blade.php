<section class="space-y-6">
    <header>
        <h2 class="text-lg text-gray-950 dark:text-gray-50 mb-2">
            {{ __('Personal identification') }}
        </h2>

        @if ($user->passport)
            @if (!$user->passport->moderation)
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    {{ __('Identity confirmed') }}
                </p>
            @else
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    {{ __('Is under moderation') }}
                </p>
            @endif
        @else
            <p class="text-sm text-gray-700 dark:text-gray-400">
                {{ __('Attach 3 scans or photos of your passport. 2-3 and 4-5 pages, also a selfie with a passport. Make sure the images are high quality and all characters are legible. After passing moderation, many seller functions will become available to you.') }}
            </p>
        @endif
    </header>

    @if (!$user->passport)
        <form method="POST" action="{{ route('passport.store') }}" enctype=multipart/form-data>
            @csrf

            <div>
                <x-input-label for="passport-images" :value="__('Photo')" />
                <x-file-input id="passport-images" name="images[]" class="mt-1 block w-full"
                    accept=".png,.jpg,.jpeg,.webp" multiple required
                    @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                <p class="mt-1 text-xxs text-gray-600" id="images_help">PNG, JPG
                    or JPEG (max. 2MB, 3 items)</p>
                <x-input-error :messages="$errors->get('images')" />
                @foreach ($errors->get('images.*') as $error)
                    <x-input-error :messages="$error" />
                @endforeach
            </div>

            <x-primary-button class="block ml-auto mt-4">{{ __('Submit for review') }}</x-primary-button>
        </form>
    @endif
</section>
