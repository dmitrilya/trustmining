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

    @php
        $n = $notification->notificationable;
        $ntName = $notification->notificationType->name;
    @endphp

    @switch($notification->notificationable_type)
        @case('App\Models\Message')
            <x-notification :href="route('support', ['chat' => true])" :type="__($ntName)" :date="$notification->created_at" :pretext="$n->user->name"
                :text="$n->message"></x-notification>
        @break

        @case('App\Models\Review')
            <x-notification :href="route('company.reviews', ['user' => $n->reviewable->url_name])" :type="__($ntName)" :date="$notification->created_at" :pretext="$n->rating"
                :text="$n->review"></x-notification>
        @break

        @case('App\Models\Moderation')
            <x-notification href="#" :type="__($ntName)" :date="$notification->created_at" :pretext="$moderationTypes[$n->moderationable_type]"
                :text="$n->comment"></x-notification>
        @break

        @case('App\Models\Ad')
            @switch($ntName)
                @case('Price change')
                    <x-notification :href="route('ads.show', ['ad' => $n->id])" :type="__($ntName)" :date="$notification->created_at" :pretext="$n->asicVersion->asicModel->name"
                        :text="$n->price"></x-notification>
                @break
            @endswitch
        @break

        @default
            @switch($ntName)
                @case('Subscription renewal failed')
                    <x-notification href="#" :type="__($ntName)" :date="$notification->created_at" pretext=""
                        :text="__('Tariff reset to Base. Reactivate on the tariffs page')"></x-notification>
                @break
                @case('Top up your balance')
                    <x-notification href="route('order.create')" :type="__($ntName)" :date="$notification->created_at" pretext=""
                        :text="__('In 7 days there will not be enough funds on the balance to extend the tariff')"></x-notification>
                @break
            @endswitch
        @endswitch
    @endforeach
