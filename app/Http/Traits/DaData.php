<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use MoveMoveIo\DaData\Enums\Language;
use MoveMoveIo\DaData\Facades\DaDataAddress;
use MoveMoveIo\DaData\Facades\DaDataCompany;

trait DaData
{
    public function dadataSuggsAddress(Request $request)
    {
        return response()->json([
            'success' => true,
            'suggestions' => DaDataAddress::prompt($request->address, 10, Language::RU)['suggestions']->pluck('value')
        ], 200);
    }

    public function dadataSuggsCity(Request $request)
    {
        return response()->json([
            'success' => true,
            'suggestions' => collect(
                DaDataAddress::prompt($request->address, 10, Language::RU, [], [], [], ["value" => "city"], ["value" => "city"])['suggestions']
            )->pluck('data.city')
        ], 200);
    }

    public function dadataCompanyByInn($inn)
    {
        //$suggs = DaDataCompany::id($inn, 1, null, 'MAIN');

        //if (!count($suggs['suggestions'])) return null;

        $suggs = [
            'suggestions' => [[
                "value" => "ООО \"ПРОММАЙНЕР\"",
                "data" => [
                    "kpp" => "772801001",
                    "capital" => [
                        "type" => "УСТАВНЫЙ КАПИТАЛ",
                        "value" => 500000
                    ],
                    "invalid" => null,
                    "founders" => [
                        [
                            "inn" => "500920523823",
                            "fio" => [
                                "surname" => "Кузьменко",
                                "name" => "Тимофей",
                                "patronymic" => "Юрьевич",
                            ],
                            "type" => "PHYSICAL",
                            "share" => [
                                "value" => 100,
                            ],
                            "invalidity" => null,
                            "start_date" => 1645045200000
                        ]
                    ],
                    "managers" => [
                        [
                            "inn" => "500920523823",
                            "fio" => [
                                "surname" => "Кузьменко",
                                "name" => "Тимофей",
                                "patronymic" => "Юрьевич",
                            ],
                            "post" => "ГЕНЕРАЛЬНЫЙ ДИРЕКТОР",
                            "type" => "EMPLOYEE",
                            "invalidity" => null,
                            "start_date" => 1708376400000
                        ]
                    ],
                    "branch_type" => "MAIN",
                    "branch_count" => 1,
                    "type" => "LEGAL",
                    "state" => [
                        "status" => "ACTIVE",
                        "code" => null,
                        "actuality_date" => 1750204800000,
                        "registration_date" => 1645056000000,
                        "liquidation_date" => null
                    ],
                    "inn" => "7720861599",
                    "ogrn" => "1227700082235",
                    "okveds" => [
                        [
                            "main" => true,
                            "type" => "2014",
                            "code" => "46.51",
                            "name" => "Торговля оптовая компьютерами, периферийными устройствами к компьютерам и программным обеспечением"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "25.99",
                            "name" => "Производство прочих готовых металлических изделий, не включенных в другие группировки"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "46.51.1",
                            "name" => "Торговля оптовая компьютерами и периферийными устройствами"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "46.51.2",
                            "name" => "Торговля оптовая программным обеспечением"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "46.52",
                            "name" => "Торговля оптовая электронным и телекоммуникационным оборудованием и его запасными частями"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "46.52.1",
                            "name" => "Торговля оптовая телекоммуникационным оборудованием и его запасными частями"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "46.52.2",
                            "name" => "Торговля оптовая электронным оборудованием и его запасными частями"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "47.41",
                            "name" => "Торговля розничная компьютерами, периферийными устройствами к ним и программным обеспечением в специализированных магазинах"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "47.41.1",
                            "name" => "Торговля розничная компьютерами в специализированных магазинах"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "47.41.2",
                            "name" => "Торговля розничная программным обеспечением в специализированных магазинах"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "47.41.3",
                            "name" => "Торговля розничная периферийными устройствами в специализированных магазинах"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "47.42",
                            "name" => "Торговля розничная телекоммуникационным оборудованием, включая розничную торговлю мобильными телефонами, в специализированных магазинах"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "47.91",
                            "name" => "Торговля розничная по почте или по информационно-коммуникационной сети Интернет"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "49.41",
                            "name" => "Деятельность автомобильного грузового транспорта"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "49.42",
                            "name" => "Предоставление услуг по перевозкам"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "52.10",
                            "name" => "Деятельность по складированию и хранению"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "52.21",
                            "name" => "Деятельность вспомогательная, связанная с сухопутным транспортом"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "52.24",
                            "name" => "Транспортная обработка грузов"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "52.29",
                            "name" => "Деятельность вспомогательная прочая, связанная с перевозками"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "53.20.3",
                            "name" => "Деятельность курьерская"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "61.10",
                            "name" => "Деятельность в области связи на базе проводных технологий"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "61.10.3",
                            "name" => "Деятельность по предоставлению услуг по передаче данных и услуг доступа к информационно-коммуникационной сети Интернет"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "61.10.4",
                            "name" => "Деятельность в области документальной электросвязи"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "62.01",
                            "name" => "Разработка компьютерного программного обеспечения"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "62.02",
                            "name" => "Деятельность консультативная и работы в области компьютерных технологий"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "62.03",
                            "name" => "Деятельность по управлению компьютерным оборудованием"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "62.03.11",
                            "name" => "Деятельность по управлению компьютерными системами непосредственно"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "62.03.12",
                            "name" => "Деятельность по управлению компьютерными системами дистанционно"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "62.03.19",
                            "name" => "Деятельность по управлению компьютерным оборудованием прочая, не включенная в другие группировки"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "62.09",
                            "name" => "Деятельность, связанная с использованием вычислительной техники и информационных технологий, прочая"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "63.11",
                            "name" => "Деятельность по обработке данных, предоставление услуг по размещению информации и связанная с этим деятельность"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "63.11.1",
                            "name" => "Деятельность по созданию и использованию баз данных и информационных ресурсов"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "63.11.9",
                            "name" => "Деятельность по предоставлению услуг по размещению информации прочая"
                        ],
                        [
                            "main" => false,
                            "type" => "2014",
                            "code" => "68.20",
                            "name" => "Аренда и управление собственным или арендованным недвижимым имуществом"
                        ]
                    ],
                    "finance" => [
                        "tax_system" => null,
                        "income" => 4872200000,
                        "expense" => 4534829000,
                        "revenue" => 4761141000,
                        "debt" => null,
                        "penalty" => null,
                        "year" => 2024
                    ],
                    "address" => [
                        "unrestricted_value" => "117246, г Москва, р-н Черемушки, Научный проезд, д 19, помещ 126Н/3",
                        "invalidity" => [
                            "code" => "FTS",
                            "decision" => null
                        ],
                    ],
                    "phones" => null,
                    "emails" => [
                        [
                            "value" => "MININGHOTELMD@GMAIL.COM",
                        ]
                    ],
                    "employee_count" => 59
                ]
            ]]
        ];

        $card = collect($suggs['suggestions'][0])->only(['value', 'data'])->all();
        $card['data'] = collect($card['data'])->only(['kpp', 'capital', 'invalid', 'founders', 'managers', 'branch_type', 'branch_count', 'type', 'state', 'inn', 'ogrn', 'okveds', 'finance', 'address', 'phones', 'emails', 'employee_count'])->all();
        $card['data']['capital'] = $card['data']['capital']['value'];
        $card['data']['founders'] = collect($card['data']['founders'])->map(fn($founder) => [
            'inn' => $founder['inn'],
            'name' => $founder['type'] == 'PHYSICAL' ? $founder['fio']['surname'] . ' ' . $founder['fio']['name'] . ' ' . $founder['fio']['patronymic'] : $founder['name'],
            'type' => $founder['type'],
            'share' => $founder['share']['value'],
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
        $card['data']['address'] = collect($card['data']['address'])->only(['unrestricted_value', 'invalidity'])->all();
        $card['data']['phones'] = $card['data']['phones'] ? collect($card['data']['phones'])->pluck(['value'])->values() : [];
        $card['data']['emails'] = $card['data']['emails'] ? collect($card['data']['emails'])->pluck('value') : [];

        return $card;
    }
}
