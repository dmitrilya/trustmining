<?php

namespace App\Services\Chat;

use Illuminate\Support\Facades\Log;

class ArtCalculator
{
    const WORK_DAY_START = 11; // 11:00
    const WORK_DAY_END = 22;   // 22:00

    /**
     * Рассчитать ART по списку чатов пользователя
     */
    public function calculateForUser($user): int
    {
        $responseCount = 0;
        $responseTime = 0;

        foreach ($user->chats as $chat) {
            $result = $this->calculateForChat($chat, $user->id);

            $responseCount += $result['count'];
            $responseTime  += $result['time'];
        }

        return $responseCount ? round($responseTime / $responseCount) : 0;
    }

    /**
     * ART по одному чату
     */
    private function calculateForChat($chat, int $sellerId): array
    {
        $responseCount = 0;
        $responseTime = 0;

        $waitingResponse = false;
        $waitingFrom = null;

        foreach ($chat->messages as $message) {

            // Покупатель написал → ждём ответа продавца
            if ($message->user_id != $sellerId) {
                if (!$waitingResponse) {
                    $waitingResponse = true;
                    $waitingFrom = $message->created_at;
                }
                continue;
            }

            // Продавец ответил
            if ($waitingResponse) {
                $waitingResponse = false;

                $interval = [
                    'start' => $waitingFrom,
                    'end'   => $message->created_at,
                ];

                $effectiveMinutes = $this->calculateEffectiveMinutes($interval);

                if ($effectiveMinutes !== null) {
                    $responseCount++;
                    $responseTime += $effectiveMinutes;
                }
            }
        }

        return [
            'count' => $responseCount,
            'time'  => $responseTime,
        ];
    }

    /**
     * Счёт минут только в дневное время (11:00–22:00)
     */
    private function calculateEffectiveMinutes(array $interval): ?int
    {
        $start = $interval['start']->copy();
        $end   = $interval['end']->copy();

        if ($end <= $start) {
            Log::channel('art')->warning('Invalid interval', [
                'start' => $start,
                'end'   => $end,
            ]);

            return null;
        }

        $total = 0;

        while ($start->isSameDay($end) || $start->lessThan($end)) {

            $dayStart = $start->copy()->setTime(self::WORK_DAY_START, 0);
            $dayEnd   = $start->copy()->setTime(self::WORK_DAY_END, 0);

            $rangeStart = $start->max($dayStart);
            $rangeEnd   = $end->min($dayEnd);

            if ($rangeEnd > $rangeStart) {
                $total += $rangeEnd->diffInMinutes($rangeStart);
            }

            $start->addDay()->startOfDay();
            if ($start->greaterThan($end)) break;
        }

        if ($total > 720) {
            Log::channel('art')->warning('Large ART detected', [
                'minutes' => $total,
                'start'   => $interval['start'],
                'end'     => $interval['end'],
            ]);
        }

        return $total;
    }
}
