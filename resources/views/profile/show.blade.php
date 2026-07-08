<x-app-layout title="Личный кабинет, профиль компании"
    description="Ваш личный кабинет: управление профилем компании и контроль баланса. Редактируйте данные и управляйте всеми услугами">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Profile') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8 relative" x-data="{ category: 'ads' }">
        <div class="flex flex-wrap gap-2 sm:gap-3 mb-4 sm:mb-6">
            @foreach (['ads' => 'Advertisements', 'insight' => 'TM Insight', 'forum' => 'Forum', 'integrations' => 'Integrations', 'notifications' => 'Notifications', 'finance' => 'Finance', 'account' => 'Account'] as $category => $category_header)
                <div @click="category = '{{ $category }}'"
                    class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 group border rounded-md"
                    :class="category ==
                        '{{ $category }}' ?
                        'bg-indigo-200 dark:bg-indigo-600 border-indigo-500 dark:border-indigo-700' :
                        'border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700'">
                    <h4 class="font-semibold text-xs lg:text-sm"
                        :class="category ==
                            '{{ $category }}' ? 'text-indigo-500 dark:text-slate-200' :
                            'text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-slate-200'">
                        {{ __($category_header) }}
                    </h4>
                </div>
            @endforeach
        </div>

        <x-profile.category x-show="category == 'ads'">
            <div class="xl:col-span-2 grid sm:grid-cols-2 gap-2">
                <x-profile.partial class="sm:col-span-2">@include('profile.partials.ads.ads')</x-profile.partial>
                <x-profile.partial class="sm:col-span-2">@include('profile.partials.ads.passport')</x-profile.partial>
            </div>

            <div class="xl:col-span-3 grid sm:grid-cols-2 gap-2">
                <x-profile.partial>@include('profile.partials.ads.company')</x-profile.partial>
                <x-profile.partial>@include('profile.partials.ads.hosting')</x-profile.partial>
                <x-profile.partial>@include('profile.partials.ads.offices')</x-profile.partial>
                <x-profile.partial>@include('profile.partials.ads.registry')</x-profile.partial>
                <x-profile.partial class="sm:col-span-2">@include('profile.partials.ads.phones')</x-profile.partial>
            </div>
        </x-profile.category>

        <x-profile.category x-show="category == 'insight'">
            <div class="order-2 lg:order-1 xl:col-span-2 grid grid-cols-1 gap-2">
                <x-profile.partial>@include('profile.partials.notifications.tg-auth')</x-profile.partial>
            </div>

            <div class="xl:col-span-3 grid grid-cols-1 gap-2">
                <x-profile.partial>@include('profile.partials.insight.insight')</x-profile.partial>
            </div>
        </x-profile.category>

        <x-profile.category x-show="category == 'forum'">
            <div class="order-2 lg:order-1 xl:col-span-2 grid grid-cols-1 gap-2">
                <x-profile.partial>@include('profile.partials.notifications.tg-auth')</x-profile.partial>
            </div>

            <div class="xl:col-span-3 grid grid-cols-1 gap-2">
                <x-profile.partial>@include('profile.partials.forum.forum')</x-profile.partial>
            </div>
        </x-profile.category>

        <x-profile.category x-show="category == 'integrations'">
            <div class="order-2 lg:order-1 xl:col-span-2 grid grid-cols-1 gap-2">
                <x-profile.partial>@include('profile.partials.integrations.api')</x-profile.partial>
            </div>

            <div class="xl:col-span-3 grid grid-cols-1 gap-2">
                <x-profile.partial>@include('profile.partials.integrations.crm-integration')</x-profile.partial>
            </div>
        </x-profile.category>

        <x-profile.category x-show="category == 'notifications'" x-data="{ settings: {{ collect($user->settings->notifications) }} }">
            <div class="xl:col-span-2 grid grid-cols-1 gap-2">
                <x-profile.partial>@include('profile.partials.notifications.tg-auth')</x-profile.partial>
                <x-profile.partial>@include('profile.partials.notifications.tracks')</x-profile.partial>
                <x-profile.partial>@include('profile.partials.notifications.difficulty-subscriptions')</x-profile.partial>
                <x-profile.partial>@include('profile.partials.notifications.update-email')</x-profile.partial>
            </div>

            <div class="xl:col-span-3 grid grid-cols-1 gap-2">
                <x-profile.partial>@include('profile.partials.notifications.notifications')</x-profile.partial>
            </div>
        </x-profile.category>

        <x-profile.category x-show="category == 'finance'">
            <div class="xl:col-span-2 grid grid-cols-1 gap-2">
                <x-profile.partial>@include('profile.partials.finance.history')</x-profile.partial>
            </div>

            <div class="xl:col-span-3 grid grid-cols-1 gap-2">
                <x-profile.partial>@include('profile.partials.finance.tariff')</x-profile.partial>
            </div>
        </x-profile.category>

        <x-profile.category x-show="category == 'account'">
            <div class="xl:col-span-2 grid grid-cols-1 gap-2">
                <x-profile.partial>@include('profile.partials.account.spins-history')</x-profile.partial>
                <x-profile.partial>@include('profile.partials.notifications.tg-auth')</x-profile.partial>
            </div>

            <div class="xl:col-span-3 grid grid-cols-1 gap-2">
                <div class="grid sm:grid-cols-2 gap-2">
                    <x-profile.partial>@include('profile.partials.account.update-profile-information-form')</x-profile.partial>

                    <div class="grid grid-cols-1 gap-2">
                        <x-profile.partial>@include('profile.partials.account.update-password-form')</x-profile.partial>
                        {{-- <x-profile.partial>@include('profile.partials.account.delete-user-form')</x-profile.partial> --}}
                    </div>
                </div>
                <x-profile.partial>@include('profile.partials.account.roulette-results')</x-profile.partial>
            </div>
        </x-profile.category>
    </div>
</x-app-layout>
