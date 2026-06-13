<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

use App\Models\Database\AsicModel;
use App\Models\User\User;

use Exception;

class UpdatePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Asic models collection.
     *
     * @var Collection
     */
    protected $models;

    /**
     * Admin api token.
     *
     * @var string
     */
    protected $apiToken;

    public function __construct()
    {
        parent::__construct();

        $this->models = AsicModel::with(['asicBrand:id,name', 'asicVersions:id,asic_model_id,hashrate'])->select(['id', 'name'])->get()
            ->map(function ($model) {
                $model->name = str_replace(' ', '', strtolower($model->name));
                return $model;
            });

        $this->apiToken = '4|hUdnSZEuKCXHOlHcMlXToUKNk0LAruPrWEKl73Ywa4385733';
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->pushminer();

        return Command::SUCCESS;
    }

    private function pushminer()
    {
        try {
            $data = collect(json_decode(file_get_contents('https://pushminer.ru/price/price_cache.json'), true));
            $ads = User::where('name', 'Pushminer')->first()->moderatedAds;

            $check = collect();
            $changings = collect();
            $conditions = [
                'Новое' => 'New',
                'б/у' => 'Used'
            ];
            $availabilities = [
                'Наличие' => 'In stock',
                'Заказ' => 'Preorder'
            ];
            foreach ($data as $row) {
                if ($row['ГТД'] == 'Криптокошелек') continue;

                $name = strtolower($row['Модель']);

                if ($row['Производитель'] == 'Bitmain') $name = 'antminer' . $name;
                elseif ($row['Производитель'] == 'Whatsminer') $name = 'whatsminer' . explode(' ', $name)[0];

                $name = str_replace(' ', '', $name);
                $variants = [
                    $name,
                    str_replace('hydro', 'hyd', $name),
                    str_replace('-', '', $name)
                ];

                if ($row['Производитель'] == 'Avalon' || $row['Производитель'] == 'Avalon Miner')
                    $variants = array_merge($variants, ['avalon' . $name, 'avalona' . $name]);

                $corrs = $this->models->whereIn('name', $variants);
                if ($corrs->count() != 1) {
                    $check->push('[Нет модели] ' . $row['Производитель'] . ' ' . $row['Модель'] . ' ' . $row['Хэшрэйт'] . ' ' . $row['Статус'] . ' ' . $row['Состояние']);
                    continue;
                }

                $model = $corrs->first();
                $rate = (float) str_replace(',', '.', $row['Хэшрэйт']);
                $version = $model->asicVersions->whereIn('hashrate', [$rate, $rate / 1000, $rate * 1000])->first();
                if (!$version) {
                    $check->push('[Нет версии] ' . $row['Производитель'] . ' ' . $row['Модель'] . ' ' . $row['Хэшрэйт'] . ' ' . $row['Статус'] . ' ' . $row['Состояние']);
                    continue;
                }

                $ad = null;
                $ads->each(function ($item, $key) use (&$ad, $ads, $version, $conditions, $row, $availabilities) {
                    if (
                        $item->asic_version_id == $version->id
                        && $conditions[$row['Состояние']] == $item->props['Condition']
                        && $availabilities[$row['Статус']] == $item->props['Availability']
                    ) {
                        $ad = $ads->pull($key);
                        return false;
                    }
                });

                if (!$ad) {
                    $check->push('[Нет объявления] ' . $row['Производитель'] . ' ' . $row['Модель'] . ' ' . $row['Хэшрэйт'] . ' ' . $row['Статус'] . ' ' . $row['Состояние']);
                    continue;
                }

                if ($row['Состояние'] == 'Новое') {
                    $price = (float) str_replace('$', '', str_replace(' ', '', $row['Цена $']));
                    if ($ad->price != $price) $changings->push([
                        'id' => $ad->id,
                        'price' => $price,
                        'coin_id' => 1
                    ]);
                } elseif ($row['Состояние'] == 'б/у') {
                    $price = (float) str_replace('₽', '', str_replace(' ', '', $row['Цена руб.']));
                    if ($ad->price != $price) $changings->push([
                        'id' => $ad->id,
                        'price' => $price,
                        'coin_id' => 2
                    ]);
                }
            }

            foreach ($ads->where('price', '!=', 0) as $ad) {
                $changings->push([
                    'id' => $ad->id,
                    'price' => 0,
                ]);
            }

            if (count($changings)) Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Accept'        => 'application/json',
            ])->post(route('api.ads.update'), ['ads' => $changings]);

            if ($check->count()) Log::channel('price-updating-check')->info("[PUSHMINER] \n" . implode("\n", $check->toArray()));
        } catch (Exception $e) {
            Log::channel('price-updating-errors')->info("[PUSHMINER] {$e->getMessage()}");
        }
    }
}
