<x-profile.section h="Telegram authorization" :p="!$user->tg_id
    ? 'You can log in using Telegram to receive notifications from our bot'
    : 'You are logged in. Notifications will come from the official telegram bot'">
    <x-tg-auth />
</x-profile.section>
