<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Traits\DaData;
use App\Models\User\Company;

class CompanyCardUpdate extends Command
{
    use DaData;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'companycard:update';

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
        foreach (Company::all() as $company) {
            $card = $this->dadataCompanyByInn($company->card->inn);

            if (!$card) {
                info('[COMPANY CARD UPDATING] card in dadata not exists {company_id=' . $company->id . '}');
                continue;
            }

            $company->card = $card['data'];
            $company->save();
        }

        return Command::SUCCESS;
    }
}
