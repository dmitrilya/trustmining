<h2 class="sr-only">{{ __('Seller information') }}</h2>

<div class="flex items-center">
    @if (
        $user->company &&
            ($user->company->logo ||
                (isset($moderation) && isset($auth) && in_array($auth->role->name, ['admin', 'moderator']) && isset($moderation->data['logo']))))
        <img class="rounded-full mr-2 {{ isset($bg) ? 'w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16' : 'w-12 h-12' }}"
            src="{{ Storage::url(isset($moderation->data['logo']) ? $moderation->data['logo'] : $user->company->logo) }}" alt="">
    @endif

    <div>
        <div class="text-xs text-slate-500">
            {{ $user->company && !$user->company->moderation ? __($user->company->card['type']) : __('Person') }}
        </div>

        <a href="{{ route('company', ['user' => $user->slug]) }}" class="hover:underline text-sm text-indigo-500 hover:text-indigo-600">{{ $user->name }}</a>
    </div>
</div>

@include('components.about-seller_tables')

<x-reviews.reviews :user="$user" />

<x-tf :tf="$user->tf" :company="$user->name" class="mt-2 sm:mt-3" />
