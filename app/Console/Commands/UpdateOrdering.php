<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Ad\Ad;
use App\Models\User\User;
use App\Models\Ad\Hosting;

class UpdateOrdering extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ordering:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ads = Ad::get(['id', 'ordering_id']);

        if ($count = $ads->count()) {
            $orderingIds = collect()->range(1, $count);
            $query = 'CASE';

            foreach ($ads as $ad) {
                $orderingId = $orderingIds->random();
                $orderingIds->forget($orderingId - 1);

                $query .= ' WHEN id = ' . $ad->id . ' THEN ' . $orderingId;
            }

            $query .= ' END';

            Ad::withoutTimestamps(fn() => Ad::query()->update(['ordering_id' => \DB::raw($query)]));
        }

        $users = User::get(['id', 'ordering_id']);

        if ($count = $users->count()) {
            $orderingIds = collect()->range(1, $count);
            $query = 'CASE';

            foreach ($users as $ad) {
                $orderingId = $orderingIds->random();
                $orderingIds->forget($orderingId - 1);

                $query .= ' WHEN id = ' . $ad->id . ' THEN ' . $orderingId;
            }

            $query .= ' END';

            User::withoutTimestamps(fn() => User::query()->update(['ordering_id' => \DB::raw($query)]));
        }

        $hostings = Hosting::get(['id', 'ordering_id']);

        if ($count = $hostings->count()) {
            $orderingIds = collect()->range(1, $count);
            $query = 'CASE';

            foreach ($hostings as $ad) {
                $orderingId = $orderingIds->random();
                $orderingIds->forget($orderingId - 1);

                $query .= ' WHEN id = ' . $ad->id . ' THEN ' . $orderingId;
            }

            $query .= ' END';

            Hosting::withoutTimestamps(fn() => Hosting::query()->update(['ordering_id' => \DB::raw($query)]));
        }

        return Command::SUCCESS;
    }
}
