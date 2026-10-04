<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use MoveMoveApp\DaData\Facades\DaDataAddress;
use MoveMoveApp\DaData\Facades\DaDataOrganization;

trait DaData
{
    public function dadataSearchAddress(string $query): array
    {
        $result = DaDataAddress::suggest([
            'query' => $query,
            'count' => 10,
            'language' => app()->getLocale() == 'ru' ? 'RU' : 'EN',
            'locations' => ['country_iso_code' => '*'],
        ]);

        return $result->suggestions ?? [];
    }

    public function dadataSuggsAddress(Request $request)
    {
        return response()->json([
            'success' => true,
            'suggestions' => collect($this->dadataSearchAddress($request->address))->pluck('value')
        ], 200);
    }

    public function dadataSearchCity(string $query)
    {
        $result = DaDataAddress::suggest([
            'query' => $query,
            'count' => 10,
            'language' => app()->getLocale() == 'ru' ? 'RU' : 'EN',
            'locations' => ['country_iso_code' => '*'],
            'from_bound' => ['value' => 'city'],
            'to_bound' => ['value' => 'city'],
        ]);

        return $result->suggestions ?? [];
    }

    public function dadataSuggsCity(Request $request)
    {
        return response()->json([
            'success' => true,
            'suggestions' => collect(
                $this->dadataSearchCity($request->address)
            )->pluck('data.city')
        ], 200);
    }

    public function dadataGetCityByIp(Request $request)
    {
        return DaDataAddress::iplocate($request->ip(), 1);
    }

    public function dadataCompanyByInn(int|string $inn)
    {
        $suggs = DaDataOrganization::id($inn, 1, null, 'MAIN');

        if (!count($suggs['suggestions'])) return null;

        $card = collect($suggs['suggestions'][0])->only(['value', 'data'])->all();
        $card['data'] = collect($card['data'])->only(['kpp', 'capital', 'invalid', 'founders', 'managers', 'branch_type', 'branch_count', 'type', 'state', 'inn', 'ogrn', 'okveds', 'finance', 'address', 'phones', 'emails', 'employee_count'])->all();
        if ($card['data']['type'] == 'LEGAL') {
            $card['data']['capital'] = isset($card['data']['capital']['value']) ? $card['data']['capital']['value'] : 10000;
            $card['data']['founders'] = collect($card['data']['founders'])->map(fn($founder) => [
                'inn' => $founder['inn'],
                'name' => $founder['type'] == 'PHYSICAL' ? $founder['fio']['surname'] . ' ' . $founder['fio']['name'] . ' ' . $founder['fio']['patronymic'] : $founder['name'],
                'type' => $founder['type'],
                'share' => isset($founder['share']['value']) ? $founder['share']['value'] : null,
                'invalidity' => $founder['invalidity'],
                'start_date' => $founder['start_date'],
            ]);
            $card['data']['managers'] = collect($card['data']['managers'])->map(function ($manager) {
                $result = [
                    'inn' => $manager['inn'],
                    'name' => $manager['type'] == 'EMPLOYEE' ? $manager['fio']['surname'] . ' ' . $manager['fio']['name'] . ' ' . $manager['fio']['patronymic'] : $manager['name'],
                    'type' => $manager['type'],
                    'invalidity' => $manager['invalidity'],
                    'start_date' => $manager['start_date'],
                ];

                if ($manager['type'] == 'EMPLOYEE') array_push($result, ['post' => $manager['post']]);

                return $result;
            });
        }

        $card['data']['address'] = collect($card['data']['address'])->only(['unrestricted_value', 'invalidity'])->all();
        $card['data']['phones'] = $card['data']['phones'] ? collect($card['data']['phones'])->pluck(['value'])->values() : [];
        $card['data']['emails'] = $card['data']['emails'] ? collect($card['data']['emails'])->pluck('value') : [];

        return $card;
    }
}
