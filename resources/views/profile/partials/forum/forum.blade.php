<section class="space-y-6">
    <header>
        <h2 class="font-extrabold text-lg text-slate-800 dark:text-slate-200 mb-2">
            {{ __('Forum profile') }}
        </h2>
    </header>

    @php
        $ranks = config('forum.ranks');
        $answerPoints = config('forum.answer');
        $helpfulAnswerPoints = config('forum.like');
        $bestAnswerPoints = config('forum.best');
    @endphp

    <a href="{{ route('forum.question.mine') }}">
        <x-buttons.secondary-button
            class="bg-secondary-gradient dark:text-slate-800">{{ __('My questions') }}</x-buttons.secondary-button>
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
            <x-inputs.input-label for="avatar" :value="__('Avatar')" />
            <x-inputs.file-input id="avatar" name="avatar" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp"
                required label="max. 1MB" />
            <x-inputs.input-error :messages="$errors->get('avatar')" />
        </div>

        <x-buttons.primary-button class="block ml-auto mt-4">{{ __('Save') }}</x-buttons.primary-button>
    </form>
</section>
