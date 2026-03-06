<x-app-layout title="Личный кабинет, профиль компании"
    description="Ваш личный кабинет: управление профилем компании и контроль баланса. Редактируйте данные и управляйте всеми услугами">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
            {{ __('Profile') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8 relative" x-data="{ category: 'ads' }">
        <div class="flex flex-wrap gap-2 sm:gap-3 mb-4 sm:mb-6">
            @foreach (['ads' => 'Advertisements', 'insight' => 'TM Insight', 'forum' => 'Forum', 'integrations' => 'Integrations', 'account' => 'Account'] as $category => $category_header)
                <div @click="category = '{{ $category }}'"
                    class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 group border border-slate-400 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700 rounded-md"
                    :class="category ==
                        '{{ $category }}' ?
                        'border-indigo-500 bg-indigo-200 dark:bg-indigo-600 dark:border-indigo-700' :
                        'border-slate-300 dark:border-slate-700'">
                    <h4 class="font-semibold text-xs lg:text-sm group-hover:text-indigo-500 dark:group-hover:text-slate-100"
                        :class="category ==
                            '{{ $category }}' ? 'text-indigo-500 dark:text-slate-50' :
                            'text-slate-500 dark:text-slate-300'">
                        {{ __($category_header) }}
                    </h4>
                </div>
            @endforeach
        </div>

        <div x-show="category == 'ads'"
            class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 items-start gap-2 absolute"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="xl:col-span-2 grid sm:grid-cols-2 gap-2">
                <div
                    class="sm:col-span-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.ads')
                </div>

                <div
                    class="p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.company')
                </div>

                <div
                    class="p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.hosting')
                </div>

                <div class="sm:col-span-2 grid sm:grid-cols-2 gap-2">
                    <div
                        class="{{ !$user->passport ? 'sm:col-span-2 order-1' : 'order-2' }} p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                        @include('profile.partials.passport')
                    </div>

                    <div
                        class="sm:col-span-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                        @include('profile.partials.tg-auth')
                    </div>
                </div>
            </div>

            <div class="xl:col-span-3 grid sm:grid-cols-2 gap-2">
                <div
                    class="sm:col-span-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.tariff')
                </div>

                <div
                    class="p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.offices')
                </div>

                <div
                    class="p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.registry')
                </div>

                <div
                    class="sm:col-span-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.phones')
                </div>
            </div>
        </div>

        <div x-show="category == 'insight'"
            class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 items-start gap-2 absolute"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="order-2 lg:order-1 xl:col-span-2 grid sm:grid-cols-2 gap-2">
                <div
                    class="sm:col-span-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.tg-auth')
                </div>
            </div>

            <div class="xl:col-span-3 grid sm:grid-cols-2 gap-2">
                <div
                    class="sm:col-span-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.insight')
                </div>
            </div>
        </div>

        <div x-show="category == 'forum'"
            class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 items-start gap-2 absolute"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="order-2 lg:order-1 xl:col-span-2 grid sm:grid-cols-2 gap-2">
                <div
                    class="sm:col-span-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.tg-auth')
                </div>
            </div>

            <div class="xl:col-span-3 grid sm:grid-cols-2 gap-2">
                <div
                    class="sm:col-span-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.forum')
                </div>
            </div>
        </div>

        <div x-show="category == 'integrations'"
            class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 items-start gap-2 absolute"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="order-2 lg:order-1 xl:col-span-2 grid sm:grid-cols-2 gap-2">
                <div
                    class="sm:col-span-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.tg-auth')
                </div>
            </div>

            <div class="xl:col-span-3 grid sm:grid-cols-2 gap-2">
                <div
                    class="sm:col-span-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.crm-integration')
                </div>
            </div>
        </div>

        <div x-show="category == 'account'"
            class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 items-start gap-2 absolute"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="order-2 lg:order-1 xl:col-span-2 grid sm:grid-cols-2 gap-2">
                <div
                    class="sm:col-span-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                    @include('profile.partials.tg-auth')
                </div>
            </div>

            <div class="xl:col-span-3 grid sm:grid-cols-2 gap-2">
                <div class="sm:col-span-2 grid sm:grid-cols-2 gap-2">
                    <div
                        class="p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div>
                        <div
                            class="p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        {{-- <div
                                class="mt-2 p-3 sm:p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
                                @include('profile.partials.delete-user-form')
                            </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
