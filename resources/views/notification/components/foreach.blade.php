@foreach ($notifications as $notification)
    @continue ($notification->notificationable_id && !$notification->notificationable)

    @php
        $n = $notification->notificationable;
        $ntName = $notification->notificationType->name;
    @endphp

    @switch($notification->notificationable_type)
        @case('message')
            <x-notifications.notification :href="$n->user->role->name == 'support' ? route('support', ['chat' => true]) :
                        route('chat', ['chat' => $n->chat_id])" :type="$ntName" :date="$notification->created_at" :pretext="$n->user->name"
                :text="$n->message"></x-notifications.notification>
        @break

        @case('review')
            <x-notifications.notification :href="route('company.reviews', ['user' => $n->reviewable->slug])" :type="$ntName" :date="$notification->created_at" :pretext="$n->rating"
                :text="$n->review"></x-notifications.notification>
        @break

        @case('moderation')
            <x-notifications.notification href="#" :type="$ntName" :date="$notification->created_at" :pretext="__('types.' . $n->moderationable_type)"
                :text="$n->comment"></x-notifications.notification>
        @break

        @case('ad')
            @switch($ntName)
                @case('Price change')
                    <x-notifications.notification :href="route('ads.show', ['adCategory' => $n->adCategory->name, 'ad' => $n->id])" :type="$ntName" :date="$notification->created_at" :pretext="$n->asicVersion->asicModel->name"
                        :text="$n->price != 0 ? $n->price . $n->coin->abbreviation : __('Price on request')"></x-notifications.notification>
                @break
            @endswitch
        @break

        @default
            @switch($ntName)
                @case('Subscription renewal failed')
                    <x-notifications.notification href="#" :type="$ntName" :date="$notification->created_at" pretext=""
                        :text="__('Tariff reset to Base. Reactivate on the tariffs page')"></x-notifications.notification>
                @break

                @case('Top up your balance (7 days)')
                    <x-notifications.notification :href="route('order.create')" :type="$ntName" :date="$notification->created_at" pretext=""
                        :text="__('In 7 days there will not be enough funds on the balance to extend the tariff')"></x-notifications.notification>
                @break

                @case('Top up your balance (3 days)')
                    <x-notifications.notification :href="route('order.create')" :type="$ntName" :date="$notification->created_at" pretext=""
                        :text="__('In 3 days there will not be enough funds on the balance to extend the tariff')"></x-notifications.notification>
                @break

                @case('Top up your balance (1 day)')
                    <x-notifications.notification :href="route('order.create')" :type="$ntName" :date="$notification->created_at" pretext=""
                        :text="__('Tomorrow there will not be enough funds on the balance to extend the tariff')"></x-notifications.notification>
                @break

                @case('Similar questions')
                    <x-notifications.notification :href="route('forum.question.mine')" :type="$ntName" :date="$notification->created_at" pretext=""
                        :text="__('Before publishing, please review questions similar to yours')"></x-notifications.notification>
                @break

                @case('New moderation')
                    <x-notifications.notification :type="$ntName" :date="$notification->created_at" pretext="" :text="__('New moderation')"></x-notifications.notification>
                @break

                @case('New forum answer')
                    <x-notifications.notification :href="route('forum.question.show', [
                        'forumCategory' => $n->forumQuestion->forumSubcategory->forumCategory->slug,
                        'forumSubcategory' => $n->forumQuestion->forumSubcategory->slug,
                        'forumQuestion' => $n->forumQuestion->id . '-' . Str::slug($n->forumQuestion->theme),
                        'answer' => $n->id,
                    ])" :type="$ntName" :date="$notification->created_at" :pretext="$n->forumQuestion->theme"
                        :text="$n->text"></x-notifications.notification>
                @break

                @case('New forum comment')
                    <x-notifications.notification :href="route('forum.question.show', [
                        'forumCategory' => $n->forumAnswer->forumQuestion->forumSubcategory->forumCategory->slug,
                        'forumSubcategory' => $n->forumAnswer->forumQuestion->forumSubcategory->slug,
                        'forumQuestion' =>
                            $n->forumAnswer->forumQuestion->id .
                            '-' .
                            Str::slug($n->forumAnswer->forumQuestion->theme),
                        'answer' => $n->forum_answer_id,
                    ])" :type="$ntName" :date="$notification->created_at" :pretext="$n->forumAnswer->forumQuestion->theme"
                        :text="$n->text"></x-notifications.notification>
                @break
            @endswitch
        @endswitch
    @endforeach
