<?php

namespace App\Services;

class ComparisonTextService
{
    public function generate($m1, $m2, $ads)
    {
        $hash = $m1->id + $m2->id; // Для фиксации выбора синонимов
        $data = $this->analyzeModels($m1, $m2);

        $sections = [];

        // Вступление (Бренд + Актуальность)
        $introKey = $data['is_old'] ? 'old_gen' : ($data['same_brand'] ? 'same_brand' : 'diff_brand');
        $sections[] = $this->getTrans("descriptions.compare.intro.{$introKey}", $hash, [
            'b1' => $m1->data->asicBrand->name,
            'm1' => $m1->name,
            'd1' => $m1->data->release->locale(app()->getLocale())->translatedFormat('F Y'),
            'b2' => $m2->data->asicBrand->name,
            'm2' => $m2->name,
            'd2' => $m2->data->release->locale(app()->getLocale())->translatedFormat('F Y')
        ]);

        // Алгоритмы и монеты
        $algoKey = $data['same_algo'] ? 'same' : 'diff';
        $sections[] = $this->getTrans("descriptions.compare.algo.{$algoKey}", $hash, [
            'm1' => $m1->name,
            'a1' => $m1->data->algorithm->name,
            'c1' => isset($m1->data->asicVersions->first()->profits) && count($m1->data->asicVersions->first()->profits) ? $m1->data->asicVersions->first()->profits[0]['coins']->pluck('name')->flatten()->unique()->implode(', ') : '',
            'all1' => isset($m1->data->asicVersions->first()->profits) && count($m1->data->asicVersions->first()->profits) ? $m1->data->asicVersions->pluck('profits.*.coins.*.name')->flatten()->unique()->implode(', ') : '',
            'm2' => $m2->name,
            'a2' => $m2->data->algorithm->name,
            'c2' => isset($m2->data->asicVersions->first()->profits) && count($m2->data->asicVersions->first()->profits) ? $m2->data->asicVersions->first()->profits[0]['coins']->pluck('name')->flatten()->unique()->implode(', ') : '',
            'all2' => isset($m2->data->asicVersions->first()->profits) && count($m2->data->asicVersions->first()->profits) ? $m2->data->asicVersions->pluck('profits.*.coins.*.name')->flatten()->unique()->implode(', ') : ''
        ]);

        $sections[] = "\n\n";

        // Хэшрейт и энергоэффективность
        if ($algoKey = $m1->data->asicVersions->count() > 1) {
            $sections[] = $this->getTrans("descriptions.compare.hashrate.more", $m1->id, [
                'b' => $m1->data->asicBrand->name,
                'm' => $m1->name,
                'minhashrate' => $m1->data->asicVersions->last()->hashrate . $m1->data->asicVersions->last()->measurement,
                'maxhashrate' => $m1->data->asicVersions->first()->hashrate . $m1->data->asicVersions->first()->measurement,
                'count' => $m1->data->asicVersions->count()
            ]);
        } else {
            $sections[] = $this->getTrans("descriptions.compare.hashrate.one", $m1->id, [
                'b' => $m1->data->asicBrand->name,
                'm' => $m1->name,
                'hashrate' => $m1->data->asicVersions->first()->hashrate . $m1->data->asicVersions->first()->measurement,
            ]);
        }

        if ($algoKey = $m2->data->asicVersions->count() > 1) {
            $sections[] = $this->getTrans("descriptions.compare.hashrate.more", $m2->id, [
                'b' => $m2->data->asicBrand->name,
                'm' => $m2->name,
                'minhashrate' => $m2->data->asicVersions->last()->hashrate . $m2->data->asicVersions->last()->measurement,
                'maxhashrate' => $m2->data->asicVersions->first()->hashrate . $m2->data->asicVersions->first()->measurement,
                'count' => $m2->data->asicVersions->count()
            ]);
        } else {
            $sections[] = $this->getTrans("descriptions.compare.hashrate.one", $m2->id, [
                'b' => $m2->data->asicBrand->name,
                'm' => $m2->name,
                'hashrate' => $m2->data->asicVersions->first()->hashrate . $m2->data->asicVersions->first()->measurement,
            ]);
        }

        if ($data['same_algo']) {
            $sections[] = $this->getTrans("descriptions.compare.hashrate.diff", $hash, [
                'm1' => $m1->name,
                'e1' => $m1->data->asicVersions->first()->efficiency . ' j/' . $m1->data->asicVersions->first()->measurement,
                'm2' => $m2->name,
                'e2' => $m2->data->asicVersions->first()->efficiency . ' j/' . $m2->data->asicVersions->first()->measurement,
                'diffPercent' => $m1->data->asicVersions->first()->original_hashrate > $m2->data->asicVersions->first()->original_hashrate ?
                    round(($m1->data->asicVersions->first()->original_hashrate - $m2->data->asicVersions->first()->original_hashrate) / $m1->data->asicVersions->first()->original_hashrate * 100, 2) :
                    round(($m2->data->asicVersions->first()->original_hashrate - $m1->data->asicVersions->first()->original_hashrate) / $m2->data->asicVersions->first()->original_hashrate * 100, 2),
                'diffValue' => abs($m2->data->asicVersions->first()->original_hashrate - $m1->data->asicVersions->first()->original_hashrate) . ' ' . $m1->data->algorithm->measurement,
            ]);
        }

        $sections[] = "\n\n";

        // Потребление
        $sections[] = $this->getTrans("descriptions.compare.power.diff", $hash, [
            'b1' => $m1->data->asicBrand->name,
            'm1' => $m1->name,
            'p1' => $m1->data->asicVersions->first()->efficiency * $m1->data->asicVersions->first()->hashrate,
            'b2' => $m2->data->asicBrand->name,
            'm2' => $m2->name,
            'p2' => $m2->data->asicVersions->first()->efficiency * $m2->data->asicVersions->first()->hashrate,
        ]);

        $sections[] = "\n\n";

        // Охлаждение
        $coolingKey = ($m1->characteristics['Cooling'] === $m2->characteristics['Cooling']) ? 'same_' . $m1->characteristics['Cooling'] : 'diff';
        $sections[] = $this->getTrans("descriptions.compare.cooling.{$coolingKey}", $hash, [
            'm1' => $m1->name,
            'm2' => $m2->name,
            'c1' => $m1->characteristics['Cooling'],
            'c2' => $m2->characteristics['Cooling']
        ]);

        $sections[] = "\n\n";

        // Объявления
        $modelAds = $ads->where('asic_model_slug', $m1->slug);
        if ($modelAds->count()) {
            $best = $modelAds->where('price', '!=', 0)->sortBy(fn($ad) => $ad->price * $ad->coin_rate)->first();
            $sections[] = $this->getTrans("descriptions.compare.ads.have", $m1->id, [
                'b' => $m1->data->asicBrand->name,
                'm' => $m1->name,
                'count' => $modelAds->count(),
                'price' => !$best ? '\"' . __('Price on request') . '\"' : $best->price . ' ' . $best->coin,
                'hashrate' => !$best ? $modelAds->first()->asic_version_hashrate . $modelAds->first()->asic_version_measurement : $best->asic_version_hashrate . $best->asic_version_measurement,
            ]);
        } else {
            $sections[] = $this->getTrans("descriptions.compare.ads.not", $m1->id, [
                'b' => $m1->data->asicBrand->name,
                'm' => $m1->name,
            ]);
        }

        $modelAds = $ads->where('asic_model_slug', $m2->slug);
        if ($modelAds->count()) {
            $best = $modelAds->where('price', '!=', 0)->sortBy(fn($ad) => $ad->price * $ad->coin_rate)->first();
            $sections[] = $this->getTrans("descriptions.compare.ads.have", $m2->id, [
                'b' => $m2->data->asicBrand->name,
                'm' => $m2->name,
                'count' => $modelAds->count(),
                'price' => !$best ? '\"' . __('Price on request') . '\"' : $best->price . ' ' . $best->coin,
                'hashrate' => !$best ? $modelAds->first()->asic_version_hashrate . $modelAds->first()->asic_version_measurement : $best->asic_version_hashrate . $best->asic_version_measurement,
            ]);
        } else {
            $sections[] = $this->getTrans("descriptions.compare.ads.not", $m2->id, [
                'b' => $m2->data->asicBrand->name,
                'm' => $m2->name,
            ]);
        }

        return implode(' ', $sections);
    }

    private function analyzeModels($m1, $m2)
    {
        return [
            'same_brand' => $m1->data->asicBrand->name === $m2->data->asicBrand->name,
            'same_algo'  => $m1->data->algorithm->name === $m2->data->algorithm->name,
            'is_old'     => $m1->data->release->year < 2022 || $m2->data->release->year < 2022,
            'is_new'     => $m1->data->release->year >= 2024 && $m2->data->release->year >= 2024,
        ];
    }

    private function getTrans($key, $hash, $params)
    {
        $translations = __($key, $params);
        if (is_array($translations)) {
            $index = $hash % count($translations);
            return $translations[$index];
        }
        return $translations;
    }
}
