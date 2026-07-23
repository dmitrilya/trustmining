<?php

namespace App\Services;

use Mews\Purifier\Facades\Purifier;
use Illuminate\Http\UploadedFile;

use App\Http\Traits\FileTrait;
use App\Http\Traits\ModerationTrait;
use App\Http\Traits\NotificationTrait;

use App\Models\Ad\Ad;
use App\Models\User\User;

class AdService
{
    use FileTrait, NotificationTrait, ModerationTrait;

    public function store(array $data, ?array $images, ?UploadedFile $preview, User $user): void
    {
        $firstAd = Ad::orderByDesc('ordering_id')->first();

        $data['with_vat'] = isset($data['with_vat']);
        $data['ordering_id'] = $firstAd ? $firstAd->ordering_id + 1 : 1;
        if (array_key_exists('description', $data))
            $data['description'] = $data['description'] ? Purifier::clean(htmlspecialchars_decode($data['description']), 'description') : '';
        $data['props'] = json_decode($data['props']);
        $data['images'] = [];

        $ad = $user->ads()->create($data);

        $time = time();
        $ad->images = $this->saveFiles($images, 'ads', 'photo', $ad->id, $time, [686, 514], $user->name);
        $ad->preview = $this->saveFile($preview, 'ads', 'preview', $ad->id, $time, [686, 514], $user->name);
        $this->saveFile($preview, 'ads', 'preview', $ad->id, $time, [320, 240], $user->name);
        $this->saveFile($preview, 'ads', 'preview', $ad->id, $time, [224, 168], $user->name);

        $ad->save();
        $ad->moderations()->create(['data' => $ad->attributesToArray()]);
    }

    public function update(Ad $ad, array $data, ?array $images, ?UploadedFile $preview): void
    {
        $data['with_vat'] = isset($data['with_vat']);
        $changings = [];

        if ($data['office_id'] != $ad->office_id) $changings['office_id'] = $data['office_id'];

        $props = collect(json_decode($data['props'], true));
        $propDiffs = $props->reject(fn($value, $key) => $value === ($ad->props[$key] ?? null))->toArray();
        if (count($propDiffs)) $data['props'] = $props;

        if (array_key_exists('description', $data) && $data['description'] != $ad->description)
            $changings['description'] = Purifier::clean(htmlspecialchars_decode($data['description']), 'description');

        $time = time();
        if ($images) $changings['images'] = $this->saveFiles($images, 'ads', 'photo', $ad->id, $time, [686, 514], $ad->user->name);

        if ($preview) {
            $changings['preview'] = $this->saveFile($preview, 'ads', 'preview', $ad->id, $time, [686, 514], $ad->user->name);
            $this->saveFile($preview, 'ads', 'preview', $ad->id, $time, [320, 240], $ad->user->name);
            $this->saveFile($preview, 'ads', 'preview', $ad->id, $time, [224, 168], $ad->user->name);
        }

        if ($data['price'] != $ad->price || $data['coin_id'] != $ad->coin_id || $data['with_vat'] != $ad->with_vat) {
            $changings['price'] = $data['price'];
            $changings['coin_id'] = $data['coin_id'];
            $changings['with_vat'] = $data['with_vat'];
        }

        if (!empty($changings)) {
            $moderation = $ad->moderations()->create(['data' => $changings]);

            if (!$preview && !$images && !isset($changings['description'])) {
                $moderation->moderation_status_id = 1;
                $this->acceptModeration(true, $moderation, User::whereHas('role', fn($q) => $q->where('name', 'admin'))->value('id'));
            }
        }
    }

    public function updateMass(array $data, User $user): void
    {
        $data = collect($data);

        $user->ads()->whereIn('id', $data->pluck('id'))->get()
            ->each(function ($ad) use ($data) {
                $change = $data->where('id', $ad->id)->first();
                $changings = [];

                if (isset($change['price']) && $change['price'] != $ad->price || isset($change['coin_id']) && $change['coin_id'] != $ad->coin_id || isset($change['with_vat']) && $change['with_vat'] != $ad->with_vat) {
                    $changings['price'] = isset($change['price']) ? $change['price'] : $ad->price;
                    $changings['coin_id'] = isset($change['coin_id']) ? $change['coin_id'] : $ad->coin_id;
                    $changings['with_vat'] = isset($change['with_vat']) ? $change['with_vat'] : $ad->with_vat;

                    $moderation = $ad->moderations()->create(['data' => $changings]);
                    $moderation->moderation_status_id = 1;
                    $this->acceptModeration(true, $moderation, User::whereHas('role', fn($q) => $q->where('name', 'admin'))->value('id'));
                }
            });
    }

    /**
     * @param  \App\Models\Ad\Ad  $ad
     * @return array 
     */
    public function getMetaData(Ad $ad): array
    {
        $user = $ad->user->name;
        $city = $ad->office->cityWhere;

        switch ($ad->adCategory->name) {
            case 'miners':
                $brand = $ad->asicVersion->asicModel->asicBrand->name;
                $model = $ad->asicVersion->asicModel->name;
                $rate = $ad->asicVersion->hashrate;
                $mes = $ad->asicVersion->measurement;
                $condition = $ad->props['Condition'] == 'New' ? 'Новый' : 'Б/у';
                $availability = $ad->props['Availability'] == 'Preorder' ? "под заказ с ожиданием до {$ad->props['Waiting (days)']} дней" : "в наличии $city";

                $name = "$model $rate$mes/s";
                $title = "$model $rate$mes купить у $user $city";
                $description = "$condition $brand $model $rate $mes/s от $user $availability. Лучшие цены, расчет доходности онлайн";
                $alt = "Оборудование для майнинга $model $rate $mes/s, производитель $brand, алгоритм {$ad->asicVersion->asicModel->algorithm->name}";
                $canonicalHref = route('ads.asic.show', [
                    'asicBrand' => $ad->asicVersion->asicModel->asicBrand->slug,
                    'asicModel' => $ad->asicVersion->asicModel->slug,
                    'asicVersion' => $rate . $mes,
                    'ad' => $ad->user->slug . '-' . $ad->id,
                ]);
                break;
            case 'gpus':
                $power = $ad->gpuModel->max_power;
                $condition = $ad->props['Condition'] == 'New' ? 'Новый' : 'Б/у';
                $availability = $ad->props['Availability'] == 'Preorder' ? "под заказ с ожиданием до {$ad->props['Waiting (days)']} дней" : "в наличии $city";

                $name = $ad->gpuModel->gpuBrand->name . ' ' . $ad->gpuModel->name;
                $title = "$name {$power}кВт/ч купить у $user $city";
                $description = "$condition ГПЭС/ГПУ $name $power кВт/ч от $user $availability. Цены, фото, реальные отзывы";
                $alt = "Газовый генератор $name, мощность $power кВт/ч";
                $canonicalHref = route('ads.gpu.show', [
                    'gpuBrand' => $ad->gpuModel->gpuBrand->slug,
                    'gpuModel' => $ad->gpuModel->slug,
                    'ad' => $ad->user->slug . '-' . $ad->id,
                ]);
                break;
            case 'legals':
                $service = $ad->props['Service'];

                $name = 'Услуга юриста по криптовалюте';
                $title = "$service - Юрист по криптовалюте $city";
                $description = "Профессиональная юридическая помощь от компании $user. Консультация, сопровождение, защита интересов по всей РФ";
                $alt = "Юрист по криптовалюте - $service";
                break;
            case 'containers':
                $capacity = $ad->props['Capacity'];
                $power = $ad->props['Power (kW)'];

                $name = 'Контейнер для майнинга';
                $title = 'Контейнеры для майнинга ';
                if ($ad->props['Length (cm)'] >= 800) $title .= '40 футов';
                else if ($ad->props['Length (cm)'] >= 400) $title .= '20 футов';
                else $title .= "на $capacity устройств";
                $title .= " купить у $user $city";
                $description = "Контейнер для $capacity асиков на $power кВт/ч $city у компании $user. Доставка по всей России. Выгодные предложения";
                $alt = "$name, вместимость до $capacity асиков, мощность до $power кВт/ч";
                break;
            case 'noiseboxes':
                $capacity = $ad->props['Capacity'] . ' ' . trans_choice('other.device', $ad->props['Capacity']);
                $material = __($ad->props['Material']);

                $name = 'Шумобокс для асика';
                $title = "$name на $capacity купить у $user $city";
                $description = "Качественный шумобокс для ASIC-майнера от компании $user из {strtolower($material)} на $capacity. Размеры, материал, вместимость";
                $alt = "$name, вместимость $capacity, материал {strtolower($material)}";
                break;
            case 'cryptoboilers':
                $capacity = $ad->props['Capacity'] . ' ' . trans_choice('other.device', $ad->props['Capacity']);
                $designation = $ad->props['Designation'];
                $area = $ad->props['Heating area (m²)'];

                $name = "Криптокотел $designation";
                $title = "Криптокотел $designation купить у $user $city";
                $description = "Криптобойлер $designation на $capacity для отопления до $area кв. м у $user. Схема, фото, актуальные цены";
                $alt = "$name, вместимость $capacity, отапливаемая площадь до $area кв. м";
                break;
            case 'water_cooling_plates':
                $models = implode(', ', $ad->props['For which models']);

                $name = "Комплект водоблоков";
                $title = "Водоблоки для $models $city";
                $description = "Комлект водоблоков для асиков $models. Цены, помощь в сборке";
                $alt = "$name для $models";
                break;
            case 'firmwares':
                $models = implode(', ', $ad->props['For which models']);

                $name = "Прошивка $user";
                $title = "Прошивка для асиков $models от $user";
                $description = "Кастомная прошивка и удаленное управление $user. Подходит для $models. Помощь в настройке";
                $alt = "Прошивка и удаленное управление $user для $models";
                break;
            case 'monitorings':
                $name = "Мониторинг асиков $user";
                $title = $name;
                $description = "Как подключиться к асику удаленно? Программа мониторинга $user. Помощь в настройке";
                $alt = "Система удаленного мониторинга $user";
                break;
            case 'accessories':
                switch ($ad->props['Category']) {
                    case 'Cables, adapters and connectors':
                        $c1 = $ad->props['Connector 1'];
                        $c2 = $ad->props['Connector 2'];
                        $name = '';

                        if (in_array($c2, ['Without plug', 'European plug (S22)', 'Chinese plug'])) {
                            $name .= "Кабель питания $c1";
                            $description = "$name для асика, {__($c2)}";

                            if ($c2 == 'Without plug') $description .= ' (под автомат)';
                        } else {
                            $name .= "Переходник $c1-$c2";
                            $description = $name;
                        }

                        $title = "$name купить у $user $city";
                        $alt = $description;
                        break;
                    case 'Coolers':
                        $size = $ad->props['Size (mm)'];
                        $amperage = $ad->props['Amperage (A)'];
                        $pin = $ad->props['Connector (pin)'];
                        $model = $ad->props['Model'];

                        $name = "Кулер {$amperage}A {$size}мм";
                        $title = "Вентилятор для асика {$amperage}A {$size}мм у $user $city";
                        $description = "Вентилятор для асика $model, {$amperage}A, {$size}мм, $pin pin";
                        $alt = "Вентилятор для асика, модель $model, ток {$amperage}A, размер {$size}мм, разъем $pin pin";
                        break;
                    default:
                        $category = __($ad->props['Category']);
                        $name = $category;
                        $title = $category;
                        $description = "$category для асика";
                        $alt = $description;
                        break;
                }

                $description .= " в магазине $user $city. Большой ассортимент, помощь с выбором";
                break;
            default:
                $title = __($ad->adCategory->header) . " купить у $user $city";
                $description = "Купите {$ad->adCategory->header} $city у компании $user. Доставка по всей России. Фото, характеристики, отзывы";
                $alt = "{$ad->adCategory->header}";
                $name = $user . ' ' . __($ad->adCategory->title);
                break;
        }

        $description .= " и ежедневные розыгрыши на сайте";

        return [$title, $description, $alt, $canonicalHref ?? route('ads.show', ['adCategory' => $ad->adCategory->name, 'ad' => $ad->id]), $name];
    }
}
