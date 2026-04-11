@props(['name' => 'Frequently Asked Questions'])

<section class="mt-4 sm:mt-6 lg:mt-8">
    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
        <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
            {{ __($name) }}
        </h2>
    </div>

    <div itemscope itemtype="https://schema.org/FAQPage" class="max-w-3xl mx-auto space-y-2 sm:space-y-4" x-data="{ active: null }">
        {{ $slot }}
    </div>
</section>
