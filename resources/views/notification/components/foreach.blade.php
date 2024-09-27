@php
    $moderationTypes = [
        'App\Models\Company' => __('Company'),
        'App\Models\Hosting' => __('Hosting'),
        'App\Models\Ad' => __('Ad'),
        'App\Models\Review' => __('Review'),
        'App\Models\Office' => __('Office'),
        'App\Models\Contact' => __('Contacts'),
        'App\Models\Passport' => __('Passport'),
    ];
@endphp

@foreach ($notifications as $notification)
    @continue (!$notification->notificationable)

    @switch($notification->notificationable_type)
        @case('App\Models\Message')
            <x-notification :href="route('support', ['chat' => true])" :type="__('New message from support')" :date="$notification->created_at" :pretext="$notification->notificationable->user->name"
                :text="$notification->notificationable->message"></x-notification>
        @break

        @case('App\Models\Review')
            <x-notification :href="route('profile.reviews')" :type="__('New review')" :date="$notification->created_at" :pretext="$notification->notificationable->rating"
                :text="$notification->notificationable->review"></x-notification>
        @break

        @case('App\Models\Moderation')
            <x-notification href="#" :date="$notification->created_at"
                :type="$notification->notificationable->moderation_status_id == 2 ? __('Moderation completed')  : __('Moderation failed')"
                :pretext="$moderationTypes[$notification->notificationable->moderationable_type]" :text="$notification->notificationable->comment">
            </x-notification>
        @break
    @endswitch
@endforeach
