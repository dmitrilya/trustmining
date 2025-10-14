@props(['clickable' => false, 'sm' => false])

<div class="flex items-center text-gray-200">
    <svg class="flex-shrink-0{{ $clickable ? ' cursor-pointer' : '' }}{{ $sm ? ' h-3 w-3 xs:h-4 xs:w-4 sm:h-5 sm:w-5' : ' h-5 w-5' }}"
        :class="{ 'text-gray-900 dark:text-zinc-600': 0 < momentRating, 'text-gray-200 dark:text-zinc-950': 0 >= momentRating }" @if ($clickable)
        @mouseenter="setMomentRating(1)" @mouseleave="resetMomentRating()" @click="setRating(1)"
        @endif
        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" clip-rule="evenodd"
            d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" />
    </svg>
    <svg class="flex-shrink-0{{ $clickable ? ' cursor-pointer' : '' }}{{ $sm ? ' h-3 w-3 xs:h-4 xs:w-4 sm:h-5 sm:w-5' : ' h-5 w-5' }}"
        :class="{ 'text-gray-900 dark:text-zinc-600': 1 < momentRating, 'text-gray-200 dark:text-zinc-950': 1 >= momentRating }" @if ($clickable)
        @mouseenter="setMomentRating(2)" @mouseleave="resetMomentRating()" @click="setRating(2)"
        @endif
        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" clip-rule="evenodd"
            d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" />
    </svg>
    <svg class="flex-shrink-0{{ $clickable ? ' cursor-pointer' : '' }}{{ $sm ? ' h-3 w-3 xs:h-4 xs:w-4 sm:h-5 sm:w-5' : ' h-5 w-5' }}"
        :class="{ 'text-gray-900 dark:text-zinc-600': 2 < momentRating, 'text-gray-200 dark:text-zinc-950': 2 >= momentRating }" @if ($clickable)
        @mouseenter="setMomentRating(3)" @mouseleave="resetMomentRating()" @click="setRating(3)"
        @endif
        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" clip-rule="evenodd"
            d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" />
    </svg>
    <svg class="flex-shrink-0{{ $clickable ? ' cursor-pointer' : '' }}{{ $sm ? ' h-3 w-3 xs:h-4 xs:w-4 sm:h-5 sm:w-5' : ' h-5 w-5' }}"
        :class="{ 'text-gray-900 dark:text-zinc-600': 3 < momentRating, 'text-gray-200 dark:text-zinc-950': 3 >= momentRating }" @if ($clickable)
        @mouseenter="setMomentRating(4)" @mouseleave="resetMomentRating()" @click="setRating(4)"
        @endif
        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" clip-rule="evenodd"
            d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" />
    </svg>
    <svg class="flex-shrink-0{{ $clickable ? ' cursor-pointer' : '' }}{{ $sm ? ' h-3 w-3 xs:h-4 xs:w-4 sm:h-5 sm:w-5' : ' h-5 w-5' }}"
        :class="{ 'text-gray-900 dark:text-zinc-600': 4 < momentRating, 'text-gray-200 dark:text-zinc-950': 4 >= momentRating }" @if ($clickable)
        @mouseenter="setMomentRating(5)" @mouseleave="resetMomentRating()" @click="setRating(5)"
        @endif
        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" clip-rule="evenodd"
            d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" />
    </svg>
</div>
