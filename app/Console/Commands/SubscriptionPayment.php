<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Traits\NotificationTrait;

use App\Models\User;
use DB;

class SubscriptionPayment extends Command
{
    use NotificationTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:subscription-payment';

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

        foreach (User::whereNotNull('tariff_id')->with(['ads:id,user_id,hidden', 'tariff:id,price'])->select(['id', 'tariff_id', 'balance'])->get() as $user) {
            if ($user->balance < $user->tariff->price) {
                $this->notify('Subscription renewal failed', $user);

                $user->tariff_id = null;

                $adIds = $user->ads->where('hidden', false)->pluck('id');
                $countToHide = $adIds->count() - 5;

                if ($countToHide > 0) $adIdsToHide = $adIdsToHide->merge($adIds->random($countToHide));
            } else {
                $user->balance -= $user->tariff->price;
            }

            $user->save();
        }

        if ($adIdsToHide->count()) DB::table('ads')->whereIn('id', $adIdsToHide)->update(['hidden' => true]);

        return Command::SUCCESS;
    }
}
