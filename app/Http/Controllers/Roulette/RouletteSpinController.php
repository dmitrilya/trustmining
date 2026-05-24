<?php

namespace App\Http\Controllers\Roulette;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\Models\Roulette\RouletteSpin;
use App\Services\RouletteSpinService;

class RouletteSpinController extends Controller
{
    protected $service;

    public function __construct(RouletteSpinService $service)
    {
        $this->service = $service;
    }

    /**
     * Spin the roulette.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function spin(Request $request): JsonResponse
    {
        $user = $request->user();

        $deviceUuid = $request->cookie('tm_device_uuid');

        if (!$this->service->canSpinAgain($user?->id, $deviceUuid)) return response()->json([
            'success' => false,
            'message' => __('Exceeded attempts. Try again later!')
        ], 422);


        $prize = $this->service->getPrize();
        if (!$deviceUuid) $deviceUuid = (string) Str::uuid();

        RouletteSpin::create([
            'user_id' => $user?->id,
            'roulette_prize_id' => $prize->id,
            'ip' => $request->ip(),
            'device_uuid' => $deviceUuid,
        ]);

        return response()->json([
            'success' => true,
            'prize' => $prize
        ])->cookie('tm_device_uuid', $deviceUuid, 2628000);
    }
}
