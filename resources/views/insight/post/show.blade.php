@php
    $channel = $channel ?? $post->channel;
@endphp

<x-insight-layout :title="$channel->name . ' - пост | TM Insight'" :description="str($post->content)->stripTags()->limit(150)" header="" itemtype="https://schema.org/WebPage">
    @php
        $user = Auth::user();
        $moder = isset($moderation) && $user && in_array($user->role->name, ['admin', 'moderator']);
    @endphp

    <x-slot name="og">
        <meta property="og:title" content="{{ __('Post') . ' | ' . $channel->name }}">
        <meta property="og:description" content="{{ str($post->content)->stripTags()->limit(150) . '...' }}">
        <meta property="og:image" content="{{ Storage::disk('public')->url($post->preview) }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="article">
        <meta property="article:published_time" content="{{ $post->created_at->toIso8601String() }}">
        <meta property="article:author" content="{{ route('insight.channel.show', ['channel' => $channel->slug]) }}">
    </x-slot>

    @if ($user && $user->id == $channel->user_id)
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    @endif
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    @if ($moder)
        <div class="max-w-7xl mx-auto px-2 sm:px-6 md:px-8 pt-8">
            @include('moderation.components.buttons', ['withUniqueCheck' => false])
        </div>
    @endif

    <div itemprop="mainEntity" itemscope itemtype="https://schema.org/SocialMediaPosting" x-data="{ edit: false }"
        class="ql-snow bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-gray-200 shadow-sm shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 mb-6 space-y-4 sm:space-y-6 lg:space-y-8">
        <div class="flex items-center justify-between">
            @include('insight.components.card-channel', [
                'name' => $channel->name,
                'logo' => $channel->logo,
                'slug' => $channel->slug,
                'subscribers' => $channel->activeSubscribers()->count(),
            ])

            @include('insight.components.sub-edit-action')
        </div>

        <div class="w-full aspect-[4/3] overflow-hidden rounded-xl flex justify-center items-center">
            @php
                $preview =
                    $moder && isset($moderation->data['preview'])
                        ? explode('.', $moderation->data['preview'])
                        : explode('.', $post->preview);
                $baseName = preg_replace('/_[0-9]+$/', '', $preview[0]);

                $previewlg = Storage::url($baseName . '_928.' . $preview[1]);
                $previewxs = Storage::url($baseName . '_400.' . $preview[1]);
            @endphp

            <picture class="w-full">
                <source media="(min-width: 430px)" srcset="{{ $previewlg }}">

                <img itemprop="image" fetchpriority="high" class="w-full" src="{{ $previewxs }}"
                    alt="Post image" />
            </picture>
        </div>

        <div x-show="!edit">
            <div itemprop="articleBody" class="ql-editor mt-6 sm:mt-8 lg:mt-10 text-xs xs:text-sm sm:text-base">
                @if ($moder && isset($moderation->data['content']))
                    {!! $moderation->data['content'] !!}
                @else
                    {!! $post->content !!}
                @endif
            </div>
        </div>

        <meta name="url" content="{{ route('insight.post.show', ['channel' => $channel->slug, 'post' => $post->id]) }}" />

        @if ($user && $user->id == $channel->user_id)
            @include('insight.post.edit')
        @endif

        @include('insight.components.content-info', ['type' => 'post', 'content' => $post])
    </div>

    @if (!$moder)
        @include('insight.components.comments.comments', ['modelType' => 'post', 'model' => $post])
    @endif

    <x-modal name="delete-modal" focusable>
        <form method="post" class="p-6"
            action="{{ route('insight.post.destroy', ['channel' => $post->channel->slug, 'post' => $post->id]) }}">
            @csrf
            @method('delete')

            <h2 class="text-lg text-gray-950 dark:text-gray-50">
                {{ __('Are you sure?') }}
            </h2>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-insight-layout>
