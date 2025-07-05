<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-4">
            <div class="grid gap-4">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    @include('profile.partials.ads')
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    @include('profile.partials.passport')
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    @include('profile.partials.company')
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    @include('profile.partials.offices')
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    @include('profile.partials.hosting')
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    @include('profile.partials.tg-auth')
                </div>
            </div>

            <div class="grid gap-4">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    @include('profile.partials.tariff')
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
