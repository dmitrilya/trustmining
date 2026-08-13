<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User\Company;
use App\Services\CheckoService;

class UpdateCompanyCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'companycards:update';

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
        $checko = new CheckoService();
        
        $total = Company::count();

        if ($total === 0) return Command::SUCCESS;

        $perDay = ceil($total / 7);
        $dayIndex = (int) date('w');

        Company::query()->orderBy('id')->skip($dayIndex * $perDay)->take($perDay)
            ->chunkById(100, function ($companies) use ($checko) {
                foreach ($companies as $company) {
                    $inn = $company->card['inn'] ?? null;
                    $type = $company->card['type'] ?? null;

                    if (!$inn || !$type) {
                        info('[COMPANY CARD UPDATING] Missing inn or type {company_id=' . $company->id . '}');
                        continue;
                    }

                    $card = $checko->companyByInn($inn, $type);

                    if (!$card) {
                        info('[COMPANY CARD UPDATING] card in checko not exists {company_id=' . $company->id . '}');
                        continue;
                    }

                    $company->card = $card['data'];
                    $company->save();
                }
            });

        return Command::SUCCESS;
    }
}
