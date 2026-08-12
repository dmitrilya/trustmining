<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Console\Command;

use App\Services\TrustFactorService;

use App\Models\User\User;

class UpdateTrustFactors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trustfactors:update';

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
        $users = User::whereHas('activeAds')->orWhereHas('hosting', fn($q) => $q->where('moderation', 'false'))
            ->orWhereHas('moderatedOffices', fn($q) => $q->where(fn($q1) => $q1->whereJsonContains('peculiarities', 'Repair service')->orWhereJsonContains('peculiarities', 'Cryptoexchanger')))
            ->select(['id', 'tf', 'art'])->with([
                'moderatedOffices:user_id,peculiarities',
                'company',
                'tariff:id,name',
                'phones:user_id,number,actual',
                'moderatedReviews:user_id,rating',
                'activeAds:user_id,ad_category_id,unique_content',
                'activeAds.adCategory:id,name'
            ])
            ->get();

        $service = app(TrustFactorService::class);

        foreach ($users as $user) {
            $service->calculate($user);
        }

        return Command::SUCCESS;
    }
}
