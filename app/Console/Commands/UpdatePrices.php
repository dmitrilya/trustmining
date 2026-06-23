<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

use App\Models\Database\AsicModel;
use App\Models\User\User;
use DOMDocument;
use DOMXPath;
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
        $users = User::whereIn('name', ['PushMiner', 'GIS mining', 'IBMM Technology', 'Mining Depot', 'Intelion Data Systems'])->with('moderatedAds')->get();
        $changings = [];

        $changings = array_merge($changings, $this->pushminer($users->where('name', 'PushMiner')->first()));
        $changings = array_merge($changings, $this->gismining($users->where('name', 'GIS mining')->first()));
        $changings = array_merge($changings, $this->ibmm($users->where('name', 'IBMM Technology')->first()));
        $changings = array_merge($changings, $this->miningdepot($users->where('name', 'Mining Depot')->first()));
        $changings = array_merge($changings, $this->intelion($users->where('name', 'Intelion Data Systems')->first()));

        if (count($changings)) Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Accept'        => 'application/json',
        ])->post(route('api.ads.update'), ['ads' => $changings]);

        return Command::SUCCESS;
    }

    private function parseModelName(string $name, bool $withRate = false): array
    {
        $lower = preg_replace('/\b-?mix\b/u', '', mb_strtolower(str_replace("\xc2\xa0", ' ', $name), 'UTF-8'));
        $rate = null;

        $rateRegex = '/\b(\d+(?:[,.]\d+)?)\s*(?:th\/s|th|mh\/s|mh|gh\/s|gh|kh\/s|kh|ksol\/s|ksol|(?:[tkmg](?![a-z0-9+])))\b/u';

        if ($withRate && preg_match($rateRegex, $lower, $matches)) {
            $rateValue = str_replace(',', '.', $matches[1]);
            $rate = is_numeric($rateValue) ? (float)$rateValue : null;

            if ($rate !== null && $rate == (int)$rate) $rate = (int)$rate;
        }

        $cleanRegex = '/\b\d+(?:[,.]\d+)?\s*(?:th\/s|th|mh\/s|mh|gh\/s|gh|kh\/s|kh|ksol\/s|ksol|w|(?:[tkmg](?![a-z0-9+])))\b/u';
        $cleaned = preg_replace($cleanRegex, '', $lower);

        $words = array_values(array_filter(explode(' ', $cleaned)));

        if (empty($words)) return $withRate ? ['', '', null] : ['', ''];

        $brand = $words[0];
        $model = implode('', array_slice($words, 1));

        if ($withRate) return [$brand, $model, $rate];

        return [$brand, $model];
    }

    private function pushminer(?User $user): array
    {
        $changings = collect();

        try {
            $data = collect(json_decode(file_get_contents('https://pushminer.ru/price/price_cache.json'), true));
            $ads = $user->moderatedAds;

            $check = collect();
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
                elseif ($row['Модель'] == 'EZ100' && $row['Хэшрэйт'] == 4000) $name = 'ez100-c';

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

            Log::channel('price-updating-check')->info("[PUSHMINER]\nОбновлено: {$changings->count()}\n" . implode("\n", $check->toArray()));
        } catch (Exception $e) {
            Log::channel('price-updating-errors')->info("[PUSHMINER] {$e->getMessage()}");
        }

        return $changings->toArray();
    }

    private function gismining(?User $user): array
    {
        $changings = collect();

        try {
            $html = file_get_contents('https://gis-mining.ru/pricelist/');
            $ads = $user->moderatedAds;

            $check = collect();

            $dom = new DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            $xpath = new DOMXPath($dom);

            foreach ($xpath->query('//tr') as $i => $row) {
                $tds = $xpath->query('.//td', $row);

                if ($tds->item(0) === null) continue;

                $fullName = trim($tds->item(0)->textContent);
                $name = $this->parseModelName($fullName);

                if ($name[1] == 'l11hu2') $name[1] = 'l11hyd2u';
                elseif ($name[1] == 'l11' && explode(' ', $tds->item(3)->textContent)[0] == 21000) $name[1] = 'l11pro';
                elseif ($name[1] == 'dghome1+') $name[1] = 'dghome1';

                $nameWithBrand = implode('', $name);

                $variants = [
                    $name[1],
                    $nameWithBrand,
                    str_replace('hydro', 'hyd', $nameWithBrand),
                    str_replace('-', '', $nameWithBrand)
                ];

                $corrs = $this->models->whereIn('name', $variants);
                if ($corrs->count() != 1) {
                    $check->push('[Нет модели] ' . $fullName);
                    continue;
                }

                $model = $corrs->first();
                $rate = (float) explode(' ', $tds->item(3)->textContent)[0];
                $version = $model->asicVersions->whereIn('hashrate', [$rate, $rate / 1000, $rate * 1000])->first();
                if (!$version) {
                    $check->push('[Нет версии] ' . $fullName);
                    continue;
                }

                $ad = null;
                $ads->each(function ($item, $key) use (&$ad, $ads, $version) {
                    if (
                        $item->asic_version_id == $version->id && 'New' == $item->props['Condition']
                        && 'Preorder' == $item->props['Availability']
                    ) {
                        $ad = $ads->pull($key);
                        return false;
                    }
                });

                if (!$ad) {
                    $check->push('[Нет объявления] ' . $fullName);
                    continue;
                }

                $price = (float) (int) preg_replace('/\D/', '', $tds->item(1)->textContent);
                if ($ad->price != $price) $changings->push([
                    'id' => $ad->id,
                    'price' => $price,
                    'coin_id' => 2
                ]);
            }

            foreach ($ads->where('price', '!=', 0) as $ad) {
                $changings->push([
                    'id' => $ad->id,
                    'price' => 0,
                ]);
            }

            Log::channel('price-updating-check')->info("[GIS MINING]\nОбновлено: {$changings->count()}\n" . implode("\n", $check->toArray()));
        } catch (Exception $e) {
            Log::channel('price-updating-errors')->info("[GIS MINING] {$e->getMessage()}");
        }

        return $changings->toArray();
    }

    private function ibmm(?User $user): array
    {
        $changings = collect();

        try {
            $html = file_get_contents('https://ibmm.ru/price/');
            $ads = $user->moderatedAds;

            $check = collect();

            $dom = new DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            $xpath = new DOMXPath($dom);

            foreach ($xpath->query('//table[@id="minersTable"]//tr') as $i => $row) {
                $tds = $xpath->query('.//td', $row);

                if ($tds->item(0) === null) continue;

                $name = trim($xpath->query('.//a', $tds->item(0))->item(0)->textContent);
                if (explode(' ', $name)[0] == 'Bitmain') $name = str_replace('Bitmain ', '', $name);
                $name = preg_replace('/[\s\p{Cyrillic}]+/u', '', strtolower($name));
                if ($name == 'antmineru3s21exph') $name = 'antminers21exphyd3u';
                elseif ($name == 'antmineru2l9h') $name = 'antminerl9hyd2u';
                $rate = (float) explode(' ', trim($tds->item(2)->textContent))[0];
                $price = (float) str_replace(' ', '', str_replace('$', '', trim($tds->item(4)->textContent)));

                $corrs = $this->models->where('name', $name);
                if ($corrs->count() != 1) {
                    $corrs = $this->models->where('name', $name . 'hyd');

                    if ($corrs->count() != 1) {
                        $check->push('[Нет модели] ' . $name . ' ' . $rate);
                        continue;
                    }
                }

                $model = $corrs->first();
                $version = $model->asicVersions->whereIn('hashrate', [$rate, $rate / 1000, $rate * 1000])->first();
                if (!$version) {
                    $model = $this->models->where('name', $name . 'hyd')->first();
                    if ($model) $version = $model->asicVersions->whereIn('hashrate', [$rate, $rate / 1000, $rate * 1000])->first();

                    if (!$version) {
                        $check->push('[Нет версии] ' . $name . ' ' . $rate);
                        continue;
                    }
                }

                $ad = null;
                $ads->each(function ($item, $key) use (&$ad, $ads, $version) {
                    if (
                        $item->asic_version_id == $version->id && 'New' == $item->props['Condition']
                        && 'Preorder' == $item->props['Availability']
                    ) {
                        $ad = $ads->pull($key);
                        return false;
                    }
                });

                if (!$ad) {
                    $check->push('[Нет объявления] ' . $name . ' ' . $rate);
                    continue;
                }

                if ($ad->price != $price) $changings->push([
                    'id' => $ad->id,
                    'price' => $price,
                    'coin_id' => 1
                ]);
            }

            foreach ($ads->where('price', '!=', 0) as $ad) {
                $changings->push([
                    'id' => $ad->id,
                    'price' => 0,
                ]);
            }

            Log::channel('price-updating-check')->info("[IBMM]\nОбновлено: {$changings->count()}\n" . implode("\n", $check->toArray()));
        } catch (Exception $e) {
            Log::channel('price-updating-errors')->info("[IBMM] {$e->getMessage()}");
        }

        return $changings->toArray();
    }

    private function miningdepot(?User $user): array
    {
        $changings = collect();

        try {
            $ads = $user->moderatedAds;
            $check = collect();
            $p = 1;

            do {
                $html = file_get_contents('https://mining-depot.ru/catalog/asicminers/?sort=price_desc&PAGEN_1=' . $p);
                $p++;

                $dom = new DOMDocument();
                @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
                $xpath = new DOMXPath($dom);

                $currentPageCards = $xpath->query('//div[contains(@class, "list-catalog")]//div[contains(@class, "info")]');

                if ($currentPageCards->length === 0) break;

                foreach ($currentPageCards as $i => $card) {
                    $price = trim($xpath->query('.//div[contains(@class, "price")]', $card)->item(0)->textContent);
                    if ($price === 'Цена по запросу') break;

                    $fullName = trim($xpath->query('.//a', $card)->item(0)->textContent);
                    $name = $this->parseModelName($fullName, true);
                    if ($name[1] == 'antmineru3s21exph') $name[1] = 'antminers21exphyd3u';
                    $nameWithBrand = $name[0] . $name[1];

                    $variants = [
                        $name[1],
                        $nameWithBrand,
                        str_replace('hydro', 'hyd', $nameWithBrand),
                        str_replace('-', '', $nameWithBrand)
                    ];
                    $rate = (float) $name[2];
                    $price = (float) preg_replace('/\D/u', '', $price);

                    $corrs = $this->models->whereIn('name', $variants);
                    if ($corrs->count() != 1) {
                        $check->push('[Нет модели] ' . $fullName);
                        continue;
                    }

                    $model = $corrs->first();
                    $version = $model->asicVersions->whereIn('hashrate', [$rate, $rate / 1000, $rate * 1000])->first();
                    if (!$version) {
                        $check->push('[Нет версии] ' . $fullName);
                        continue;
                    }

                    $ad = null;
                    $ads->each(function ($item, $key) use (&$ad, $ads, $version) {
                        if (
                            $item->asic_version_id == $version->id && 'New' == $item->props['Condition']
                            && 'Preorder' == $item->props['Availability']
                        ) {
                            $ad = $ads->pull($key);
                            return false;
                        }
                    });

                    if (!$ad) {
                        $check->push('[Нет объявления] ' . $fullName);
                        continue;
                    }

                    if ($ad->price != $price) $changings->push([
                        'id' => $ad->id,
                        'price' => $price,
                        'coin_id' => 2
                    ]);
                }

                usleep(100000);
            } while (trim($xpath->query('.//div[contains(@class, "price")]', $currentPageCards->item($currentPageCards->length - 1))->item(0)->textContent) !== 'Цена по запросу');

            foreach ($ads->where('price', '!=', 0) as $ad) {
                $changings->push([
                    'id' => $ad->id,
                    'price' => 0,
                ]);
            }

            Log::channel('price-updating-check')->info("[MINING DEPOT]\nОбновлено: {$changings->count()}\n" . implode("\n", $check->toArray()));
        } catch (Exception $e) {
            Log::channel('price-updating-errors')->info("[MINING DEPOT] {$e->getMessage()}");
        }

        return $changings->toArray();
    }

    private function intelion(?User $user): array
    {
        $changings = collect();

        try {
            $ads = $user->moderatedAds;
            $check = collect();
            $p = 1;

            do {
                $html = file_get_contents('https://intelionmine.ru/catalog/asic-miners?sort=price_desc&page=' . $p);
                $p++;

                $dom = new DOMDocument();
                @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
                $xpath = new DOMXPath($dom);

                $currentPageCards = $xpath->query('//div[contains(@class, "catalog__grid__main")]//div[@class="i-catalog-item__info"]');

                if ($currentPageCards->length === 0) break;

                foreach ($currentPageCards as $i => $card) {
                    $price = $xpath->query('.//span[contains(@class, "i-catalog-item__price__number")]', $card)->item(0);
                    if (!$price) {
                        $price = $xpath->query('.//span[contains(@class, "i-catalog-item__price__on-request")]', $card)->item(0);
                        if ($price) break;
                    }

                    $fullName = trim($xpath->query('.//span[contains(@class, "i-catalog-item__name")]', $card)->item(0)->textContent);
                    $name = $this->parseModelName($fullName, true);
                    $nameWithBrand = $name[0] . $name[1];

                    $variants = [
                        $name[1],
                        $nameWithBrand,
                        str_replace('hydro', 'hyd', $nameWithBrand),
                        str_replace('hydro', 'hyd', $name[1]),
                        str_replace('-', '', $nameWithBrand)
                    ];
                    $rate = (float) $name[2];
                    $price = (float) preg_replace('/\D/u', '', trim($price->textContent));

                    $corrs = $this->models->whereIn('name', $variants);
                    if ($corrs->count() != 1) {
                        $check->push('[Нет модели] ' . $fullName);
                        continue;
                    }

                    $model = $corrs->first();
                    $version = $model->asicVersions->whereIn('hashrate', [$rate, $rate / 1000, $rate * 1000])->first();
                    if (!$version) {
                        $check->push('[Нет версии] ' . $fullName);
                        continue;
                    }

                    $ad = null;
                    $ads->each(function ($item, $key) use (&$ad, $ads, $version) {
                        if (
                            $item->asic_version_id == $version->id && 'New' == $item->props['Condition']
                            && 'Preorder' == $item->props['Availability']
                        ) {
                            $ad = $ads->pull($key);
                            return false;
                        }
                    });

                    if (!$ad) {
                        $check->push('[Нет объявления] ' . $fullName);
                        continue;
                    }

                    if ($ad->price != $price) $changings->push([
                        'id' => $ad->id,
                        'price' => $price,
                        'coin_id' => 2
                    ]);
                }

                usleep(100000);
            } while (!$xpath->query('.//span[contains(@class, "i-catalog-item__price__on-request")]', $currentPageCards->item($currentPageCards->length - 1))->item(0));

            foreach ($ads->where('price', '!=', 0) as $ad) {
                $changings->push([
                    'id' => $ad->id,
                    'price' => 0,
                ]);
            }

            Log::channel('price-updating-check')->info("[INTELION]\nОбновлено: {$changings->count()}\n" . implode("\n", $check->toArray()));
        } catch (Exception $e) {
            Log::channel('price-updating-errors')->info("[INTELION] {$e->getMessage()}");
        }

        return $changings->toArray();
    }
}
