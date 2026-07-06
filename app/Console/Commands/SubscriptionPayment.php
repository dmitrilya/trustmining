<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Traits\NotificationTrait;

use Carbon\Carbon;

use App\Models\User\User;

class SubscriptionPayment extends Command
{
    use NotificationTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscription Payment';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $adIdsToHide = collect();

        foreach (
            User::whereNotNull('tariff_id')->where('tariff_from', '<', Carbon::now()->yesterday())
                ->with(['ads:id,user_id,hidden', 'tariff:id,price'])->select(['id', 'tariff_id', 'balance', 'tg_id'])->get() as $user
        ) {
            if ($user->balance < $user->tariff->price) {
                $this->notify('Subscription renewal failed', new Collection([$user]));

                $user->tariff_id = null;
                $user->tariff_from = null;

                $adIds = $user->ads->where('hidden', false)->pluck('id');
                $countToHide = $adIds->count() - config('settings.ads.max_count_without_tariff');

                if ($countToHide > 0) $adIdsToHide = $adIdsToHide->merge($adIds->random($countToHide));
            } else {
                if ($user->balance < $user->tariff->price * 8 && $user->balance >= $user->tariff->price * 7) $this->notify('Top up your balance (7 days)', new Collection([$user]));
                elseif ($user->balance < $user->tariff->price * 4 && $user->balance >= $user->tariff->price * 3) $this->notify('Top up your balance (3 days)', new Collection([$user]));
                elseif ($user->balance < $user->tariff->price * 2 && $user->balance >= $user->tariff->price) $this->notify('Top up your balance (1 day)', new Collection([$user]));

                $user->balance -= $user->tariff->price;
            }

            $user->save();
        }

        if ($adIdsToHide->count()) \DB::table('ads')->whereIn('id', $adIdsToHide)->update(['hidden' => true]);

        return Command::SUCCESS;
    }
}
