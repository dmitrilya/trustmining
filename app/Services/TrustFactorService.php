<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\User\User;

class TrustFactorService
{
    protected array $config;
    protected array $data = [];

    public function __construct()
    {
        $this->config = config('trustfactor');
    }

    /**
     * Обычный расчет Trust Factor.
     * Возвращает только итоговый TF.
     */
    public function calculate(User $user): int|float
    {
        $oldTF = $user->tf ?? null;

        $result = $this->calculateDetailed($user);

        $user->tf = $result['tf'];
        $user->save();

        $this->logIfAnomaly($user, $oldTF, $result['tf']);

        return $result['tf'];
    }

    /**
     * Подробный расчет Trust Factor.
     */
    public function calculateDetailed(User $user): array
    {
        $this->prepareData($user);

        $direction = $this->detectDirection($user);

        $tf = $this->config['base'];
        $max = $this->config['base'];

        $factors = [];

        foreach ($this->config['factors']['active'] as $name) {
            $factor = $this->config['factors']['directions'][$direction][$name]
                ?? $this->config['factors']['default'][$name]
                ?? null;

            if (!$factor || !$this->checkCondition($factor['condition'] ?? null)) continue;

            $result = $this->calculateFactor($name, $factor);

            if (!$result) continue;

            $tf += $result['score'];
            $max += $result['max'];

            $factors[] = $result;
        }

        $tf = round($tf / $max * 100);

        return [
            'direction' => $direction,
            'tf' => $tf,
            'factors' => $factors,
        ];
    }

    /**
     * Расчет одной проверки.
     */
    private function calculateFactor(string $name, array $factor): array
    {
        $value = $this->getData($factor['source']);

        if (isset($factor['thresholds'])) {
            $thresholdResult = $this->calculateThreshold($value, $factor['thresholds']);

            return [
                'name' => $name,
                'type' => 'threshold',
                'value' => $value,
                'score' => $thresholdResult['score'],
                'max' => max($factor['thresholds']),
                'thresholds' => $factor['thresholds'],
                'matched_threshold' => $thresholdResult['threshold'],
            ];
        }

        $passed = (bool) $value;

        $score = $passed ? ($factor['bonus'] ?? 0) : ($factor['penalty'] ?? 0);

        return [
            'name' => $name,
            'type' => 'boolean',
            'value' => $value,
            'score' => $score,
            'max' => $factor['bonus'] ?? 0,
            'bonus' => $factor['bonus'] ?? 0,
            'penalty' => $factor['penalty'] ?? 0,
        ];
    }

    /**
     * Определяет сработавший порог.
     */
    private function calculateThreshold(int|float|null $value, array $thresholds): array
    {
        foreach ($thresholds as $threshold => $score) {
            if ($value >= $threshold) {
                return [
                    'threshold' => $threshold,
                    'score' => $score,
                ];
            }
        }

        return [
            'threshold' => null,
            'score' => 0,
        ];
    }

    /**
     * Проверка условия выполнения фактора.
     */
    private function checkCondition(?array $condition): bool
    {
        if (!$condition) return true;

        $actual = $this->getData($condition['source']);
        $expected = $condition['value'];

        return match ($condition['operator']) {
            '==' => $actual == $expected,
            '!=' => $actual != $expected,
            '>'  => $actual > $expected,
            '>=' => $actual >= $expected,
            '<'  => $actual < $expected,
            '<=' => $actual <= $expected,
            default => false,
        };
    }

    /**
     * Получение подготовленного значения.
     */
    private function getData(string $source): mixed
    {
        return data_get($this->data, $source);
    }

    /**
     * Подготовка всех данных, которые используются проверками.
     */
    private function prepareData(User $user): void
    {
        $company = $user->company;
        $card = $company?->card ?? [];

        $reviews = $user->moderatedReviews;

        $realReviews = $reviews->where('fake', false);
        $fakeReviews = $reviews->where('fake', true);

        $activeAdsCount = $user->activeAds->count();

        $uniqueAdsCount = $user->activeAds
            ->where('unique_content', true)
            ->count();

        $this->data = [
            'company' => [
                'exists' => (bool) $company,
                'legal_entity' => ($card['type'] ?? null) === 'LEGAL',
                'status_active' => ($card['state']['status'] ?? null) === 'ACTIVE',
                'branches' => $card['branch_count'] ?? 0,
                'invalid' => !isset($card['invalid']) || $card['invalid'] != null,
                'registration_age' =>  isset($card['state']['registration_date'])
                    ? Carbon::now()->diffInMonths(
                        Carbon::createFromTimestampMs(
                            $card['state']['registration_date']
                        )
                    ) : 0,
                'capital' => $card['capital'] ?? 0,
                'income' => $card['finance'] && $card['finance']['income'] ? $card['finance']['income'] / 100 : 0,
                'employees' => $card['employee_count'] ?? 0,
                'site' => (bool) ($company?->site),
                'video' => (bool) ($company?->video),
                'images' => count($company?->images) ?? 0,
            ],

            'reviews' => [
                'count' => $realReviews->count(),
                'average' => $realReviews->avg('rating') ?? 0,
                'fake_count' => $fakeReviews->count(),
            ],

            'offices' => [
                'count' => $user->moderatedOffices->count(),
            ],

            'ads' => [
                'count' => $activeAdsCount,
                'unique_ratio' => $activeAdsCount ? $uniqueAdsCount / $activeAdsCount * 100 : 0,
            ],

            'response_time' => $user->art,

            'registry' => [
                'exists' => (bool) $company->registry,
            ],

            'hosting' => [
                'exists' => (bool) ( $user->hosting && !$user->hosting->moderation),
                'visiting_territory' => (bool) ( $user->hosting && !$user->hosting->moderation && in_array(
                        'Possibility of visiting the territory',
                        $user->hosting->peculiarities ?? []
                    )
                ),
            ],
        ];
    }

    /**
     * Определение основного направления компании.
     */
    private function detectDirection(User $user): string
    {
        $directionsConfig = $this->config['directions'];

        $map = $directionsConfig['map'];
        $weights = $directionsConfig['weights'];

        $ads = $user->activeAds;

        $scores = [
            'miners'        => 0,
            'legals'        => 0,
            'containers'    => 0,
            'noiseboxes'    => 0,
            'cryptoboilers' => 0,
            'firmwares'     => 0,
            'gpus'          => 0,
            'hosting'       => 0,
            'service'       => 0,
            'exchanger'     => 0,
        ];

        $hasMinersAds = $ads->contains(
            fn($ad) => $ad->adCategory->name === 'miners'
        );

        foreach ($ads as $ad) {
            $category = $ad->adCategory->name;

            if ($category === 'noiseboxes') $direction = $hasMinersAds ? 'miners' : 'noiseboxes';
            else $direction = $map[$category] ?? null;

            if ($direction) $scores[$direction] += $weights[$category] ?? 0;
        }

        if ($user->hosting && !$user->hosting->moderation) {
            $scores['hosting'] += $weights['hosting'] ?? 0;
        }

        foreach ($user->moderatedOffices as $office) {
            if (in_array('Repair service', $office->peculiarities ?? [])) $scores['service'] += $weights['service'] ?? 0;

            if (in_array('Cryptoexchanger', $office->peculiarities ?? [])) $scores['exchanger'] += $weights['exchanger'] ?? 0;
        }

        arsort($scores);

        return array_key_first($scores);
    }

    /**
     * Логирование резкого изменения TF.
     */
    private function logIfAnomaly(User $user, int|float|null $old, int|float $new): void
    {
        if ($old === null) {
            Log::channel('trustfactor')->info("[TF INIT] user={$user->id} tf=$new");
            return;
        }

        $diff = abs($old - $new);

        $threshold = $this->config['log_diff_threshold'];

        if ($diff >= $threshold) Log::channel('trustfactor')->warning("[TF ANOMALY] user={$user->id} old=$old new=$new diff=$diff");
    }
}
