@foreach ($notifications as $notification)
    @continue ($notification->notificationable_id && !$notification->notificationable)

    @php
        $n = $notification->notificationable;
        $ntName = $notification->notificationType->name;
    @endphp

    @switch($notification->notificationable_type)
        @case('message')
            <x-notification :href="route('support', ['chat' => true])" :type="$ntName" :date="$notification->created_at" :pretext="$n->user->name"
                :text="$n->message"></x-notification>
        @break

        @case('review')
            <x-notification :href="route('company.reviews', ['user' => $n->reviewable->url_name])" :type="$ntName" :date="$notification->created_at" :pretext="$n->rating"
                :text="$n->review"></x-notification>
        @break

        @case('moderation')
            <x-notification href="#" :type="$ntName" :date="$notification->created_at" :pretext="__('types.' . $n->moderationable_type)"
                :text="$n->comment"></x-notification>
        @break

        @case('ad')
            @switch($ntName)
                @case('Price change')
                    <x-notification :href="route('ads.show', ['adCategory' => $n->adCategory->name, 'ad' => $n->id])" :type="$ntName" :date="$notification->created_at" :pretext="$n->asicVersion->asicModel->name"
                        :text="$n->price != 0 ? $n->price : __('Price on request')"></x-notification>
                @break
            @endswitch
        @break

        @default
            @switch($ntName)
                @case('Subscription renewal failed')
                    <x-notification href="#" :type="$ntName" :date="$notification->created_at" pretext=""
                        :text="__('Tariff reset to Base. Reactivate on the tariffs page')"></x-notification>
                @break

                @case('Top up your balance (7 days)')
                    <x-notification :href="route('order.create')" :type="$ntName" :date="$notification->created_at" pretext=""
                        :text="__('In 7 days there will not be enough funds on the balance to extend the tariff')"></x-notification>
                @break

                @case('Top up your balance (3 days)')
                    <x-notification :href="route('order.create')" :type="$ntName" :date="$notification->created_at" pretext=""
                        :text="__('In 3 days there will not be enough funds on the balance to extend the tariff')"></x-notification>
                @break

                @case('Top up your balance (1 day)')
                    <x-notification :href="route('order.create')" :type="$ntName" :date="$notification->created_at" pretext=""
                        :text="__('Tomorrow there will not be enough funds on the balance to extend the tariff')"></x-notification>
                @break

                @case('Similar questions')
                    <x-notification :href="route('forum.question.index')" :type="$ntName" :date="$notification->created_at" pretext=""
                        :text="__('Before publishing, please review questions similar to yours')"></x-notification>
                @break

                @case('New forum answer')
                    <x-notification :href="route('forum.question.show', [
                        'forumCategory' => strtolower(
                            str_replace(' ', '_', $n->forumQuestion->forumSubcategory->forumCategory->name),
                        ),
                        'forumSubcategory' => strtolower(
                            str_replace(' ', '_', $n->forumQuestion->forumSubcategory->name),
                        ),
                        'forumQuestion' =>
                            $n->forumQuestion->id .
                            '-' .
                            mb_strtolower(str_replace([' ', '/'], '-', $n->forumQuestion->theme)),
                        'answer' => $n->id,
                    ])" :type="$ntName" :date="$notification->created_at" :pretext="$n->forumQuestion->theme"
                        :text="$n->text"></x-notification>
                @break

                @case('New forum comment')
                    <x-notification :href="route('forum.question.show', [
                        'forumCategory' => strtolower(
                            str_replace(
                                ' ',
                                '_',
                                $n->forumAnswer->forumQuestion->forumSubcategory->forumCategory->name,
                            ),
                        ),
                        'forumSubcategory' => strtolower(
                            str_replace(' ', '_', $n->forumAnswer->forumQuestion->forumSubcategory->name),
                        ),
                        'forumQuestion' =>
                            $n->forumAnswer->forumQuestion->id .
                            '-' .
                            mb_strtolower(str_replace([' ', '/'], '-', $n->forumAnswer->forumQuestion->theme)),
                        'answer' => $n->forum_answer_id,
                    ])" :type="$ntName" :date="$notification->created_at" :pretext="$n->forumAnswer->forumQuestion->theme"
                        :text="$n->text"></x-notification>
                @break
            @endswitch
        @endswitch
    @endforeach
