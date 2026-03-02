<x-app-layout title="Модерация" noindex="true">
    <x-slot name="header">
        <div class="flex items-center justify-end">
            <p class="text-slate-700 dark:text-slate-300 text-semibold text-lg mr-6">{{ $moderations->count() }}</p>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center border border-transparent text-sm leading-4 rounded-md text-slate-600 dark:text-slate-300 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ __('Model') }}</div>

                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                @php
                    $model = request()->model;
                @endphp

                <x-slot name="content">
                    <x-dropdown-link ::class="{ 'bg-slate-200': {{ $model == 'company' ? 'true' : 'false' }} }" :href="route('moderations', ['model' => 'company'])">
                        {{ __('Company') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-slate-200': {{ $model == 'hosting' ? 'true' : 'false' }} }" :href="route('moderations', ['model' => 'hosting'])">
                        {{ __('Hosting') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-slate-200': {{ $model == 'ad' ? 'true' : 'false' }} }" :href="route('moderations', ['model' => 'ad'])">
                        {{ __('Advertisements') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-slate-200': {{ $model == 'review' ? 'true' : 'false' }} }" :href="route('moderations', ['model' => 'review'])">
                        {{ __('Reviews') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-slate-200': {{ $model == 'office' ? 'true' : 'false' }} }" :href="route('moderations', ['model' => 'office'])">
                        {{ __('Offices') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-slate-200': {{ $model == 'passport' ? 'true' : 'false' }} }" :href="route('moderations', ['model' => 'passport'])">
                        {{ __('Passport') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-slate-200': {{ $model == 'channel' ? 'true' : 'false' }} }" :href="route('moderations', ['model' => 'channel'])">
                        {{ __('Channel') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-slate-200': {{ $model == 'article' ? 'true' : 'false' }} }" :href="route('moderations', ['model' => 'article'])">
                        {{ __('Article') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-slate-200': {{ $model == 'post' ? 'true' : 'false' }} }" :href="route('moderations', ['model' => 'post'])">
                        {{ __('Post') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6">
            <ul role="list" class="divide-y divide-slate-300 dark:divide-slate-700">
                @foreach ($moderations as $moderation)
                    @php
                        $user = $moderation->moderationable->user
                            ? $moderation->moderationable->user
                            : $moderation->moderationable->channel->user;
                        $logo = $moderation->moderationable->user
                            ? ($user->company
                                ? $user->company->logo
                                : null)
                            : $moderation->moderationable->channel->logo;
                        $name = $moderation->moderationable->user
                            ? $user->name
                            : $moderation->moderationable->channel->name;
                    @endphp

                    <a href="{{ route('moderation', ['moderation' => $moderation->id]) }}"
                        class="rounded-md hover:bg-slate-200 dark:hover:bg-slate-950 block p-4">
                        <li>
                            <div class="flex">
                                @if ($logo)
                                    <img class="h-12 w-12 flex-none rounded-full bg-slate-50 mr-4"
                                        src="{{ Storage::url($logo) }}" alt="">
                                @endif

                                <div class="w-full">
                                    <p class="text-sm font-semibold leading-6 text-slate-800 dark:text-slate-200">
                                        {{ $name }}
                                    </p>

                                    <div class="flex justify-between">
                                        <p class="mt-1 truncate text-xs leading-5 text-slate-600 dark:text-slate-400">
                                            {{ __('types.' . $moderation->moderationable_type) }}
                                        </p>

                                        <p class="date-transform mt-1 text-xs leading-5 text-slate-600 dark:text-slate-400"
                                            data-date="{{ $moderation->created_at }}">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </a>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
