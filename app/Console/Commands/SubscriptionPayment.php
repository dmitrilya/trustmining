<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Traits\NotificationTrait;

use Carbon\Carbon;

use App\Models\User;

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
            User::whereHas(
                'tariff',
                fn($q) => $q->where('created_at', '<', Carbon::now()->yesterday())
            )->with(['ads:id,user_id,hidden', 'tariff:id,price'])->select(['id', 'tariff_id', 'balance'])->get() as $user
        ) {
            if ($user->balance < $user->tariff->price) {
                $this->notify('Subscription renewal failed', collect([$user]));

                $user->tariff_id = null;

                $adIds = $user->ads->where('hidden', false)->pluck('id');
                $countToHide = $adIds->count() - 2;

                if ($countToHide > 0) $adIdsToHide = $adIdsToHide->merge($adIds->random($countToHide));
            } else {
                if ($user->balance < $user->tariff->price * 7) $this->notify('Top up your balance', collect([$user]));

                $user->balance -= $user->tariff->price;
            }

            $user->save();
        }

        if ($adIdsToHide->count()) \DB::table('ads')->whereIn('id', $adIdsToHide)->update(['hidden' => true]);

        return Command::SUCCESS;
    }
}
