<x-insight-layout :title="$video->title" :description="$video->title" header="" itemtype="https://schema.org/WebPage">
    @php
        $user = Auth::user();
        $moder = isset($moderation) && $user && in_array($user->role->name, ['admin', 'moderator']);
        if ($moder) {
            $channel = $video->channel;
        }
    @endphp

    @if ($moder)
        <div class="max-w-7xl mx-auto px-2 sm:px-6 md:px-8 pt-8">
            @include('moderation.components.buttons', ['withUniqueCheck' => false])
        </div>
    @endif

    <div itemprop="mainEntity" itemscope itemtype="https://schema.org/VideoObject" x-data="{ edit: false }"
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

        @include('insight.components.content-info', ['type' => 'video', 'content' => $video])

        <h1 itemprop="name" class="font-bold text-lg lg:text-xl text-gray-900 dark:text-gray-100 leading-tight">{{ $video->title }}</h1>

        <meta itemprop="description"
                content="{{ __('Channel') . ' ' . $channel->name . ' - ' . __('Video') . ' ' . $video->title }}" />
        <meta itemprop="thumbnailUrl" content="{{ Storage::url($video->preview) }}">

        <iframe itemprop="embedUrl" src="{{ $video->url }}" frameborder="0" class="aspect-[16/9] rounded-xl w-full"></iframe>

        @if ($user && $user->id == $channel->user_id)
            @include('insight.video.edit')
        @endif
    </div>

    @if (!$moder)
        @include('insight.components.comments.comments', ['modelType' => 'video', 'model' => $video])
    @endif

    <x-modal name="delete-modal" focusable>
        <form method="post" class="p-6"
            action="{{ route('insight.video.destroy', ['channel' => $video->channel->slug, 'video' => $video->id]) }}">
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
