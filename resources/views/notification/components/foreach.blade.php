@foreach ($notifications as $notification)
    @switch($notification->notificationable_type)
        @case('App\Models\Message')
            <x-notification :href="route('support', ['chat' => true])" :type="__('New message from support')" :date="$notification->created_at" :pretext="$notification->notificationable->user->name"
                :text="$notification->notificationable->message"></x-notification>
        @break

        @case('App\Models\Review')
            <x-notification :href="route('profile.reviews')" :type="__('New review')" :date="$notification->created_at" :pretext="$notification->notificationable->rating"
                :text="$notification->notificationable->review"></x-notification>
        @break
    @endswitch
@endforeach
