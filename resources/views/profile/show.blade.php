<x-app-layout title="Личный кабинет, профиль компании" description="Ваш личный кабинет: управление профилем компании и контроль баланса. Редактируйте данные и управляйте всеми услугами">
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Profile') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 items-start gap-2">
            <div class="xl:col-span-2 grid sm:grid-cols-2 gap-2">
                <div class="sm:col-span-2 p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                    @include('profile.partials.ads')
                </div>

                <div
                    class="{{ !$user->passport && (!$user->company || $user->company->moderation) ? 'sm:col-span-2' : 'order-last' }} p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                    @include('profile.partials.passport')
                </div>

                <div class="p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                    @include('profile.partials.company')
                </div>

                <div class="p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                    @include('profile.partials.hosting')
                </div>

                <div class="sm:col-span-2 p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                    @include('profile.partials.offices')
                </div>

                <div class="sm:col-span-2 p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                    @include('profile.partials.phones')
                </div>

                <div class="p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                    @include('profile.partials.tg-auth')
                </div>

                <div class="p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                    @include('profile.partials.registry')
                </div>
            </div>

            <div class="xl:col-span-3 grid sm:grid-cols-2 gap-2">
                <div class="sm:col-span-2 p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                    @include('profile.partials.tariff')
                </div>

                <div class="p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                    @include('profile.partials.crm-integration')
                </div>

                <div class="p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="sm:col-span-2 grid sm:grid-cols-2 gap-2">
                    <div class="p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div>
                        <div class="p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                            @include('profile.partials.forum')
                        </div>

                        {{-- <div class="mt-2 p-3 sm:p-4 bg-white dark:bg-zinc-900 shadow rounded-lg">
                            @include('profile.partials.delete-user-form')
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
