<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Console\Command;

use App\Http\Traits\TrustFactor;

use App\Models\User;

class UpdateTrustFactors extends Command
{
    use TrustFactor;

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
        $users = User::whereHas('ads', function (Builder $query) {
            $query->where('moderation', 'false')->where('hidden', 'false');
        })->orWhereHas('hosting', function (Builder $query) {
            $query->where('moderation', 'false');
        })->select(['id', 'tf', 'art'])
            ->with(['moderatedOffices', 'company', 'tariff:id,name', 'moderatedReviews:user_id,rating', 'ads:user_id,unique_content'])
            ->get();

        foreach ($users as $user) {
            $this->calculateTrustFactor($user);
        }

        return Command::SUCCESS;
    }
}
