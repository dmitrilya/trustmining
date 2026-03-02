<x-app-layout noindex="true">
    <div
        class="w-full px-2 absolute top-1/3 xs:top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center justify-center">
        <p class="font-bold text-lg xs:text-2xl sm:text-3xl lg:text-4xl text-slate-900 dark:text-slate-100 leading-tight mb-4 sm:mb-6 lg:mb-8">
            {{ __('Session timed out') }}
        </p>
        <p class="text-xs xs:text-sm sm:text-base lg:text-lg text-slate-600 dark:text-slate-400 mb-6 sm:mb-8 lg:mb-10">
            {{ __('Please refresh the page and submit your request again') }}
        </p>

        <div class="w-full aspect-[16/9] max-w-xl rounded-b-lg overflow-hidden">
            <video autoplay muted loop playsinline poster="/img/error.webp" width="100%">
                <source src="/img/error.mp4" type="video/mp4">
                Ваш браузер не поддерживает встроенные видео.
            </video>
        </div>
    </div>
</x-app-layout>
