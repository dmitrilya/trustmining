@props(['images', 'alt', 'previews_position' => 'left', 'aspect' => '4/3'])

<div class="flex{{ $previews_position != 'left' ? ' flex-col-reverse' : '' }} items-start gap-2" x-data="{ active: 0 }">
    <div class="flex {{ $previews_position == 'left' ? 'flex-col' : 'flex-wrap' }} gap-2" aria-hidden="true">
        @foreach ($images as $index => $image)
            <div @click="active = {{ $index }}" class="min-w-16 w-16 aspect-{{ $aspect }} rounded-lg overflow-hidden cursor-pointer transition"
                :class="active === {{ $index }} ? 'ring-2 ring-indigo-500' :
                    'opacity-80 hover:opacity-100'">
                <img src="{{ Storage::url($image) }}" alt="" class="w-full h-full rounded-lg object-cover">
            </div>
        @endforeach
    </div>

    <div class="relative w-full aspect-{{ $aspect }} rounded-xl overflow-hidden bg-white/40 dark:bg-slate-900/40">
        @foreach ($images as $index => $image)
            <div x-show="active === {{ $index }}" x-transition.opacity.duration.300ms class="absolute inset-0">
                <img itemprop="image" src="{{ Storage::url($image) }}" alt="{{ $alt }} - {{ __('Image') }} {{ $index + 1 }}"
                    class="w-full h-full rounded-xl object-scale-down">
            </div>
        @endforeach
    </div>
</div>
