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

            if (!$factor || !$this->checkConditions($factor['conditions'] ?? [])) continue;

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
            'max' => $max,
            'factors' => $factors,
        ];
    }

    /**
     * Расчет одной проверки.
     */
    private function calculateFactor(string $name, array $factor): array
    {
        if (($factor['type'] ?? null) === 'group') {
            $exists = (bool) $this->getData($factor['source']);

            if (!$exists) {
                $score = $factor['penalty'] ?? 0;

                return [
                    'name' => $name,
                    'type' => 'boolean',
                    'value' => $exists,
                    'score' => $score,
                    'max' => $factor['bonus'] ?? 0,
                    'bonus' => $factor['bonus'] ?? 0,
                    'penalty' => $factor['penalty'] ?? 0,
                    'components' => [],
                ];
            }

            $score = 0;
            $max = 0;
            $components = [];

            foreach ($factor['components'] ?? [] as $componentName => $component) {
                if (!$this->checkConditions($component['conditions'] ?? [])) continue;

                $result = $this->calculateFactor($componentName, $component);

                $score += $result['score'];
                $max += $result['max'];
                $components[] = $result;
            }

            return [
                'name' => $name,
                'type' => 'group',
                'value' => $exists,
                'score' => $score,
                'max' => $max,
                'bonus' => $factor['bonus'] ?? 0,
                'penalty' => $factor['penalty'] ?? 0,
                'components' => $components,
            ];
        }

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

    private function checkConditions(array $conditions): bool
    {
        foreach ($conditions as $condition) {
            if (!$this->checkCondition($condition)) {
                return false;
            }
        }

        return true;
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

        $phone = $user->phones->first();

        $this->data = [
            'company' => [
                'exists' => (bool) $company,
                'legal_entity' => ($card['type'] ?? null) === 'LEGAL',
                'status_active' => ($card['status'] ?? null) === 'Действует',
                'branches' => $card['branch_count'] ?? 0,
                'registration_age' =>  isset($card['registration_date'])
                    ? Carbon::now()->diffInMonths(
                        Carbon::createFromTimestamp(
                            $card['registration_date']
                        )
                    ) : 0,
                'capital' => $card['capital'] ?? 0,
                'income' => $card['finance'] && $card['finance']['income'] ? $card['finance']['income'] / 100 : 0,
                'profit' => $card['finance'] && $card['finance']['profit'] ? $card['finance']['profit'] / 100 : 0,
                'employees' => $card['employee_count'] ?? 0,
                'video' => (bool) ($company?->video),
                'images' => count($company?->images) ?? 0,
            ],

            'website' => $this->checkWebsite($company?->site),

            'phone' => [
                'exists' => (bool) $phone,
                'actual' => (bool) $phone->actual,
                'toll_free' => (bool) mb_substr($phone->number, 0, 4) == 7800
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
                'exists' => (bool) ($user->hosting && !$user->hosting->moderation),
                'visiting_territory' => (bool) ($user->hosting && !$user->hosting->moderation && in_array(
                    'Possibility of visiting the territory',
                    $user->hosting->peculiarities ?? []
                )),
            ],
        ];
    }

    private function checkWebsite(?string $url): array
    {
        if (!$url) return [
            'exists' => false,
            'https' => false,
            'reachable' => false,
        ];

        $url = trim($url);
        if (!preg_match('#^https?://#i', $url)) $url = 'https://' . $url;
        $parts = parse_url($url);
        $host = $parts['host'] ?? null;

        if (!$host) return [
            'exists' => false,
            'https' => false,
            'reachable' => false,
        ];

        $https = false;
        $reachable = false;

        try {
            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => true,
                    'verify_peer_name' => true,
                    'allow_self_signed' => false,
                    'SNI_enabled' => true,
                    'peer_name' => $host,
                ],
            ]);

            $socket = @stream_socket_client("ssl://{$host}:443", $errno, $errstr, 5, STREAM_CLIENT_CONNECT, $context);

            if ($socket) {
                $https = true;
                fclose($socket);
            }
        } catch (\Throwable $e) {
            $https = false;
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'method' => 'HEAD',
                    'timeout' => 5,
                    'ignore_errors' => true,
                    'follow_location' => true,
                    'max_redirects' => 5,
                ],
            ]);

            $headers = @get_headers($url, true, $context);

            if ($headers !== false) {
                $statusLine = $headers[0] ?? '';

                preg_match('#HTTP/\S+\s+(\d{3})#', $statusLine, $matches);

                $status = isset($matches[1]) ? (int) $matches[1] : null;
                $reachable = $status !== null && $status >= 200 && $status < 400;
            }
        } catch (\Throwable $e) {
            $reachable = false;
        }

        return [
            'exists' => true,
            'https' => $https,
            'reachable' => $reachable,
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
