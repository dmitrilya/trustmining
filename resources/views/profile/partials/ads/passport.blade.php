<section class="space-y-6">
    <header>
        <h2 class="font-extrabold text-lg text-slate-800 dark:text-slate-200 mb-2">
            {{ __('Personal identification') }}
        </h2>

        @if ($user->passport)
            @if (!$user->passport->moderation)
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('Identity confirmed') }}
                </p>
            @else
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('Is under moderation') }}
                </p>
            @endif
        @else
            <p class="text-sm text-slate-600 dark:text-slate-400">
                {{ __('Attach 3 scans or photos of your passport. 2-3 and 4-5 pages, also a selfie with a passport. Make sure the images are high quality and all characters are legible. After passing moderation, many seller functions will become available to you.') }}
            </p>
        @endif
    </header>

    @if (!$user->passport)
        <form method="POST" action="{{ route('passport.store') }}" enctype=multipart/form-data>
            @csrf

            <div>
                <x-inputs.input-label for="passport-images" :value="__('Photo')" />
                <x-inputs.file-input id="passport-images" name="images[]" class="mt-1 block w-full"
                    accept=".png,.jpg,.jpeg,.webp" multiple max="3" required label="max. 2MB, 3 items" />
                <x-inputs.input-error :messages="$errors->get('images')" />
                @foreach ($errors->get('images.*') as $error)
                    <x-inputs.input-error :messages="$error" />
                @endforeach
            </div>

            <x-buttons.primary-button class="block ml-auto mt-4">{{ __('Submit for review') }}</x-buttons.primary-button>
        </form>
    @endif
</section>
