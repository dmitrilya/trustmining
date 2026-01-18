<section class="space-y-6">
    <header>
        <h2 class="text-lg text-gray-950 dark:text-gray-50 mb-2">
            {{ __('Forum profile') }}
        </h2>
    </header>

    @php
        $ranks = config('forum.ranks');
        $answerPoints = config('forum.answer');
        $helpfulAnswerPoints = config('forum.like');
        $bestAnswerPoints = config('forum.best');
    @endphp

    <a href="{{ route('forum.question.index') }}">
        <x-secondary-button class="bg-secondary-gradient !text-gray-900">{{ __('My questions') }}</x-secondary-button>
    </a>

    @include('forum.components.author', [
        'id' => $user->id,
        'name' => $user->name,
        'forumScore' => $user->forum_score,
        'messages' => $user->moderatedForumAnswers()->count(),
    ])

    <form method="POST" action="{{ route('forum.avatar.update') }}" enctype=multipart/form-data>
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="avatar" :value="__('Avatar')" />
            <x-file-input id="avatar" name="avatar" class="mt-1 block w-full" :value="old('avatar')"
                accept=".png,.jpg,.jpeg,.webp" required />
            <p class="mt-1 text-xxs text-gray-600" id="avatar_help">PNG, JPG
                or JPEG (max. 1MB)</p>
            <x-input-error :messages="$errors->get('avatar')" />
        </div>

        <x-primary-button class="block ml-auto mt-4">{{ __('Save') }}</x-primary-button>
    </form>
</section>
