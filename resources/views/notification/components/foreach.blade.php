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
    @continue ($notification->notificationable_id && !$notification->notificationable)

    @switch($notification->notificationable_type)
        @case('App\Models\Message')
            <x-notification :href="route('support', ['chat' => true])" :type="__($notification->notificationType->name)" :date="$notification->created_at" :pretext="$notification->notificationable->user->name"
                :text="$notification->notificationable->message"></x-notification>
        @break

        @case('App\Models\Review')
            <x-notification :href="route('profile.reviews')" :type="__($notification->notificationType->name)" :date="$notification->created_at" :pretext="$notification->notificationable->rating"
                :text="$notification->notificationable->review"></x-notification>
        @break

        @case('App\Models\Moderation')
            <x-notification href="#" :date="$notification->created_at" :type="__($notification->notificationType->name)" :pretext="$moderationTypes[$notification->notificationable->moderationable_type]"
                :text="$notification->notificationable->comment"></x-notification>
        @break

        @case('App\Models\Ad')
            @switch($notification->notificationType->name)
                @case('Price change')
                    <x-notification :href="route('ads.show', ['ad' => $notification->notificationable->id])" :date="$notification->created_at" :type="__($notification->notificationType->name)" :pretext="$notification->notificationable->asicVersion->asicModel->name"
                        :text="$notification->notificationable->price"></x-notification>
                @break
            @endswitch
        @break

        @default
            @switch($notification->notificationType->name)
                @case('Subscription renewal failed')
                    <x-notification href="#" :type="__($notification->notificationType->name)" :date="$notification->created_at" pretext=""
                        :text="__('Tariff reset to Base. Reactivate on the tariffs page')"></x-notification>
                @break
            @endswitch
    @endswitch
@endforeach