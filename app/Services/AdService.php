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

        $props = collect($data['props']);
        $propDiffs = $props->reject(fn($value, $key) => $value === ($ad->props[$key] ?? null))->toArray();
        if (count($propDiffs)) $changings['props'] = $props;

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

        $condition = function () use ($ad) {
            return $ad->props['Condition'] === 'New' ? __('meta.ad.show.conditions.new') : __('meta.ad.show.conditions.used');
        };

        $availability = function () use ($ad, $city) {
            return $ad->props['Availability'] === 'Preorder'
                ? __('meta.ad.show.availability.preorder', ['days' => $ad->props['Waiting (days)']])
                : __('meta.ad.show.availability.in_stock', ['city' => $city]);
        };

        $meta = function (string $key, array $replace = []) use ($ad) {
            return __('meta.ad.show.' . $ad->adCategory->name . '.' . $key, $replace);
        };

        switch ($ad->adCategory->name) {
            case 'miners':
                $brand = $ad->asicVersion->asicModel->asicBrand->name;
                $model = $ad->asicVersion->asicModel->name;
                $rate = $ad->asicVersion->hashrate;
                $mes = $ad->asicVersion->measurement;

                $data = ['brand' => $brand, 'model' => $model, 'rate' => $rate, 'measurement' => $mes, 'condition' => $condition(), 'availability' => $availability(), 'user' => $user, 'city' => $city, 'algorithm' => $ad->asicVersion->asicModel->algorithm->name];

                $name = $meta('name', $data);
                $title = $meta('title', $data);
                $description = $meta('description', $data);
                $alt = $meta('alt', $data);

                $canonicalHref = route('ads.asic.show', [
                    'asicBrand' => $ad->asicVersion->asicModel->asicBrand->slug,
                    'asicModel' => $ad->asicVersion->asicModel->slug,
                    'asicVersion' => $rate . $mes,
                    'ad' => $ad->user->slug . '-' . $ad->id,
                ]);

                break;
            case 'gpus':
                $power = $ad->gpuModel->max_power;
                $brand = $ad->gpuModel->gpuBrand->name;
                $model = $ad->gpuModel->name;

                $data = ['brand' => $brand, 'model' => $model, 'name' => $brand . ' ' . $model, 'power' => $power, 'condition' => $condition(), 'availability' => $availability(), 'user' => $user, 'city' => $city];

                $name = $meta('name', $data);
                $title = $meta('title', $data);
                $description = $meta('description', $data);
                $alt = $meta('alt', $data);

                $canonicalHref = route('ads.gpu.show', [
                    'gpuBrand' => $ad->gpuModel->gpuBrand->slug,
                    'gpuModel' => $ad->gpuModel->slug,
                    'ad' => $ad->user->slug . '-' . $ad->id,
                ]);

                break;
            case 'legals':
                $service = $ad->props['Service'];

                $data = ['service' => $service, 'user' => $user, 'city' => $city];

                $name = $meta('name', $data);
                $title = $meta('title', $data);
                $description = $meta('description', $data);
                $alt = $meta('alt', $data);

                break;
            case 'containers':
                $capacity = $ad->props['Capacity'];
                $power = $ad->props['Power (kW)'];
                $length = $ad->props['Length (cm)'];

                $data = ['capacity' => $capacity, 'power' => $power, 'user' => $user, 'city' => $city, 'name' => __('meta.ad.show.containers.name')];

                if ($length >= 800) $title = __('meta.ad.show.containers.title_size', array_merge($data, ['size' => 40]));
                elseif ($length >= 400) $title = __('meta.ad.show.containers.title_size', array_merge($data, ['size' => 20]));
                else $title = __('meta.ad.show.containers.title_devices', $data);

                $name = __('meta.ad.show.containers.name');
                $description = __('meta.ad.show.containers.description', $data);
                $alt = __('meta.ad.show.containers.alt', $data);

                break;
            case 'noiseboxes':
                $capacity = $ad->props['Capacity'] . ' ' . trans_choice('other.device', $ad->props['Capacity']);
                $material = __($ad->props['Material']);

                $data = ['name' => __('meta.ad.show.noiseboxes.name'), 'capacity' => $capacity, 'material' => mb_strtolower($material), 'user' => $user, 'city' => $city];

                $name = $data['name'];
                $title = $meta('title', $data);
                $description = $meta('description', $data);
                $alt = $meta('alt', $data);

                break;
            case 'cryptoboilers':
                $capacity = $ad->props['Capacity'] . ' ' . trans_choice('other.device', $ad->props['Capacity']);
                $designation = $ad->props['Designation'];
                $area = $ad->props['Heating area (m²)'];

                $data = ['name' => __('meta.ad.show.cryptoboilers.name', ['designation' => $designation]), 'designation' => $designation, 'capacity' => $capacity, 'area' => $area, 'user' => $user, 'city' => $city];

                $name = $data['name'];
                $title = $meta('title', $data);
                $description = $meta('description', $data);
                $alt = $meta('alt', $data);

                break;
            case 'water_cooling_plates':
                $models = implode(', ', $ad->props['For which models']);

                $data = ['name' => __('meta.ad.show.water_cooling_plates.name'), 'models' => $models, 'city' => $city];

                $name = $data['name'];
                $title = $meta('title', $data);
                $description = $meta('description', $data);
                $alt = $meta('alt', $data);

                break;
            case 'firmwares':
                $maxMode = collect($ad->props['Modes'])->sortBy('h')->last()['h'];

                $model = $ad->asicVersion->asicModel->name;
                $rate = $ad->asicVersion->hashrate;
                $measurement = $ad->asicVersion->measurement;

                $data = ['user' => $user, 'model' => $model, 'rate' => $rate, 'measurement' => $measurement, 'max_mode' => $maxMode];

                $name = $meta('name', $data);
                $title = $meta('title', $data);
                $description = $meta('description', $data);
                $alt = $meta('alt', $data);

                break;
            case 'monitorings':
                $data = ['user' => $user];

                $name = $meta('name', $data);
                $title = $meta('title', $data);
                $description = $meta('description', $data);
                $alt = $meta('alt', $data);

                break;
            case 'accessories':
                switch ($ad->props['Category']) {
                    case 'Cables, adapters and connectors':
                        $c1 = $ad->props['Connector 1'];
                        $c2 = $ad->props['Connector 2'];
                        $name = '';

                        if (in_array($c2, ['Without plug', 'European plug (S22)', 'Chinese plug'])) {
                            $name .= __('meta.ad.show.accessories.cables.power_cable_name', ['connector' => $c1]);
                            $description = __('meta.ad.show.accessories.cables.power_cable_description', ['name' => $name, 'connector' => __($c2)]);

                            if ($c2 == 'Without plug') $description .= __('meta.ad.show.accessories.cables.without_plug_suffix');
                        } else {
                            $name .= __('meta.ad.show.accessories.cables.adapter_name', ['connector1' => $c1, 'connector2' => $c2]);
                            $description = __('meta.ad.show.accessories.cables.adapter_description', ['name' => $name]);
                        }

                        $title = __('meta.ad.show.accessories.cables.title', ['name' => $name, 'user' => $user, 'city' => $city]);
                        $alt = $description;

                        break;
                    case 'Coolers':
                        $size = $ad->props['Size (mm)'];
                        $amperage = $ad->props['Amperage (A)'];
                        $pin = $ad->props['Connector (pin)'];
                        $model = $ad->props['Model'];

                        $data = ['amperage' => $amperage, 'size' => $size, 'pin' => $pin, 'model' => $model, 'user' => $user, 'city' => $city];

                        $name = __('meta.ad.show.accessories.coolers.name', $data);
                        $title = __('meta.ad.show.accessories.coolers.title', $data);
                        $description = __('meta.ad.show.accessories.coolers.description', $data);
                        $alt = __('meta.ad.show.accessories.coolers.alt', $data);

                        break;
                    default:
                        $category = __($ad->props['Category']);
                        $name = $category;
                        $title = $category;
                        $description = __('meta.ad.show.accessories.default.description', ['category' => $category]);
                        $alt = $description;

                        break;
                }

                $description .= __('meta.ad.show.accessories.suffix', ['user' => $user, 'city' => $city]);

                break;
            default:
                $category = __($ad->adCategory->header);
                $categoryTitle = __($ad->adCategory->title);

                $data = ['category' => $category, 'user' => $user, 'city' => $city, 'title' => $categoryTitle];

                $title = __('meta.ad.show.default.title', $data);
                $description = __('meta.ad.show.default.description', $data);
                $alt = __('meta.ad.show.default.alt', $data);
                $name = __('meta.ad.show.default.name', $data);

                break;
        }

        $description .= __('meta.ad.show.suffix');

        return [$title, $description, $alt, $canonicalHref ?? route('ads.show', ['adCategory' => $ad->adCategory->name, 'ad' => $ad->id]), $name];
    }
}
