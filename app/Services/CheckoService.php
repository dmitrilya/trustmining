<?php

namespace App\Services;

use Carbon\Carbon;

class CheckoService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.checko.key');
    }

    public function checkoCompanyByInn(string|int $inn): ?array
    {
        $inn = (string) $inn;

        $info = $this->getCompanyInfo($inn);

        if ($info === null) return null;

        $finance = $this->getCompanyFinance($inn);

        return $this->processData($info, $finance);
    }

    public function getCompanyInfo(string $inn, ?string $type = null): ?array
    {
        if ($type) {
            $response = $this->request(($type == 'LEGAL' ? 'company' : 'entrepreneur'), ['inn' => $inn]);
        } else {
            $response = $this->request('company', ['inn' => $inn]);

            if (!empty($response['data'])) $type = 'LEGAL';
            else {
                $response = $this->request('entrepreneur', ['inn' => $inn]);

                if (!empty($response['data'])) $type = 'INDIVIDUAL';
                else return null;
            }
        }

        $response['data']['type'] = $type;

        return $response['data'];
    }

    public function getCompanyFinance(string $inn): ?array
    {
        $finance = $this->request('finances', ['inn' => $inn])['data'] ?? null;

        return $finance ? end($finance) : null;
    }

    /*[ // app/Console/Commands/MyCommand.php:59
    "ОГРН" => "1162468103181"
    "ИНН" => "2466174775"
    "КПП" => "246601001"
    "ОКПО" => "04495820"
    "ДатаРег" => "2016-09-13"
    "ДатаОГРН" => "2016-09-13"
    "НаимСокр" => "ООО "ЖЕЛТАЯ СУБМАРИНА""
    "НаимАнгл" => null
    "НаимПолн" => "ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ЖЕЛТАЯ СУБМАРИНА""
    "Статус" => array:2 [
      "Код" => "001"
      "Наим" => "Действует"
    ]
    "Регион" => array:2 [
      "Код" => "24"
      "Наим" => "Красноярский край"
    ]
    "ЮрАдрес" => array:5 [
      "НасПункт" => "г. Красноярск"
      "АдресРФ" => "660049, Красноярский край, г. Красноярск, ул. Бограда, д. 12, кв. 13"
      "ИдГАР" => null
      "Недост" => false
      "МассАдрес" => array:2 [
        0 => "1202400001385"
        1 => "1232400019345"
      ]
    ]
    "ОКВЭД" => array:3 [
      "Код" => "68.20"
      "Наим" => "Аренда и управление собственным или арендованным недвижимым имуществом"
      "Версия" => "2014"
    ]
    "ОКВЭДДоп" => array:3 [
      0 => array:3 [
        "Код" => "46.51"
        "Наим" => "Торговля оптовая компьютерами, периферийными устройствами к компьютерам и программным обеспечением"
        "Версия" => "2014"
      ]
      1 => array:3 [
        "Код" => "47.41"
        "Наим" => "Торговля розничная компьютерами, периферийными устройствами к ним и программным обеспечением в специализированных магазинах"
        "Версия" => "2014"
      ]
      2 => array:3 [
        "Код" => "47.79.3"
        "Наим" => "Торговля розничная прочими бывшими в употреблении товарами"
        "Версия" => "2014"
      ]
    ]
    "РегФНС" => array:3 [
      "КодОрг" => "2468"
      "НаимОрг" => "Межрайонная инспекция Федеральной налоговой службы №23 по Красноярскому краю"
      "АдресОрг" => "660133, Красноярск г, Партизана Железняка ул, 46"
    ]
    "ТекФНС" => array:3 [
      "КодОрг" => "2466"
      "НаимОрг" => "Межрайонная инспекция Федеральной налоговой службы №28 по Красноярскому краю"
      "ДатаПостУч" => "2016-09-13"
    ]
    "УстКап" => array:2 [
      "Тип" => "УСТАВНЫЙ КАПИТАЛ"
      "Сумма" => 10000
    ]
    "УпрОрг" => []
    "Руковод" => array:1 [
      0 => array:10 [
        "ФИО" => "Андреев Игорь Владимирович"
        "ИНН" => "246605802770"
        "ВидДолжн" => "РУКОВОДИТЕЛЬ ЮРИДИЧЕСКОГО ЛИЦА"
        "НаимДолжн" => "ГЕНЕРАЛЬНЫЙ ДИРЕКТОР"
        "Недост" => false
        "МассРуковод" => false
        "ДисквЛицо" => false
        "СвязРуковод" => array:3 [
          0 => "1202400001385"
          1 => "1192468036397"
          2 => "1232400019345"
        ]
        "СвязУчред" => array:3 [
          0 => "1192468036397"
          1 => "1232400019345"
          2 => "1022402145193"
        ]
        "ДатаЗаписи" => "2016-09-13"
      ]
    ]
    "Учред" => array:5 [
      "ФЛ" => array:1 [
        0 => array:8 [
          "ФИО" => "Андреев Игорь Владимирович"
          "ИНН" => "246605802770"
          "Недост" => false
          "МассУчред" => false
          "Доля" => array:2 [
            "Номинал" => 10000.0
            "Процент" => 100.0
          ]
          "СвязРуковод" => array:3 [
            0 => "1202400001385"
            1 => "1192468036397"
            2 => "1232400019345"
          ]
          "СвязУчред" => array:3 [
            0 => "1192468036397"
            1 => "1232400019345"
            2 => "1022402145193"
          ]
          "ДатаЗаписи" => "2016-09-13"
        ]
      ]
      "РосОрг" => []
      "ИнОрг" => []
      "ПИФ" => []
      "РФ" => []
    ]
    "СвязУпрОрг" => []
    "СвязУчред" => []
    "ДержРеестрАО" => []
    "Лиценз" => []
    "ТоварЗнак" => []
    "Подразд" => []
    "Правопредш" => []
    "Правопреем" => []
    "ДатаВып" => "2026-07-29"
    "Контакты" => array:1 [
      "Тел" => array:1 [
        0 => "+79082122100"
      ]
    ]
    "Налоги" => array:6 [
      "ОсобРежим" => []
      "СведУпл" => array:6 [
        0 => array:2 [
          "Наим" => "Налог на добавленную стоимость"
          "Сумма" => 118876.0
        ]
        1 => array:2 [
          "Наим" => "Налог на прибыль"
          "Сумма" => 16030.0
        ]
        2 => array:2 [
          "Наим" => "Страховые взносы на обязательное социальное страхование на случай временной нетрудоспособности и в связи с материнством"
          "Сумма" => 0.0
        ]
        3 => array:2 [
      "Код" => "24"
          "Наим" => "Страховые и другие взносы на обязательное пенсионное страхование, зачи
  сляемые в Пенсионный фонд Российской Федерации"
          "Сумма" => 6802.84
        ]
        4 => array:2 [
          "Наим" => "Суммы пеней"
          "Сумма" => 1285.75
        ]
        5 => array:2 [
          "Наим" => "НЕНАЛОГОВЫЕ ДОХОДЫ, администрируемые налоговыми органами"
          "Сумма" => 1125.0
        ]
      ]
      "СумУпл" => "144119.59"
      "СведУплГод" => "2025"
      "СумНедоим" => "114467.36"
      "НедоимДата" => "2026-07-01"
    ]
    "ПоддержМСП" => []
    "СЧР" => 4
    "СЧРГод" => "2025"
    "ЕФРСБ" => []
    "НедобПост" => false
    "ДисквЛица" => false
    "МассРуковод" => false
    "МассУчред" => false
    "НелегалФин" => false
    "Санкции" => false
    "СанкцУчр" => false
  ] */

    private function processData(array $companyInfo, ?array $finance): array
    {
        $risks = array_filter([
            "ЕФРСБ" => count($companyInfo["ЕФРСБ"]),
            "НедобПост" => $companyInfo["НедобПост"] ?? false,
            "ДисквЛица" => $companyInfo["ДисквЛица"] ?? false,
            "МассРуковод" => $companyInfo["МассРуковод"] ?? false,
            "МассУчред" => $companyInfo["МассУчред"] ?? false,
            "НелегалФин" => $companyInfo["НелегалФин"] ?? false,
            "Санкции" => $companyInfo["Санкции"] ?? false,
            "СанкцУчр" => $companyInfo["СанкцУчр"] ?? false,
        ], fn($v) =>  $v === true || (is_array($v) && !empty($v)));

        $card = [
            "inn" => $companyInfo['ИНН'],
            "ogrn" => $companyInfo['ОГРН'] ?? $companyInfo['ОГРНИП'],
            "okpo" => $companyInfo['ОКПО'],
            "type" => $companyInfo['type'],
            "registration_date" => Carbon::create($companyInfo['ДатаРег'])->timestamp,
            "status" => $companyInfo['Статус']['Наим'],
            "okveds" => array_merge([$companyInfo['ОКВЭД']], $companyInfo['ОКВЭДДоп']),
            "phones" => (array) ($companyInfo['Контакты']['Тел'] ?? []),
            "emails" => (array) ($companyInfo['Контакты']['Емэйл'] ?? []),
            "website" => $companyInfo['Контакты']['ВебСайт'] ?? null,
            "address" => $companyInfo['type'] == 'LEGAL' ? $companyInfo['ЮрАдрес']['АдресРФ'] : $companyInfo['Регион']['Наим'] . ', ' . $companyInfo['ОКТМО']['Наим'],
            "finance" => [
                "income" => $finance['2110'] ?? null,
                "profit" => $finance['2400'] ?? null
            ],
            "risks" => $risks,
            "branch_count" => count($companyInfo['Подразд']['Филиал'] ?? []),
            "employee_count" => $companyInfo['СЧР'] ?? null,
        ];

        if ($companyInfo['type'] == 'LEGAL') {
            $card['kpp'] = $companyInfo['КПП'];
            $card['capital'] = $companyInfo['УстКап']['Сумма'];

            $founders = [];
            foreach (($companyInfo['Учред']['ФЛ'] ?? []) as $founder) {
                array_push($founders, [
                    "inn" => $founder['ИНН'],
                    "name" => $founder['ФИО'],
                    "share" => $founder['Доля']['Процент'],
                ]);
            }
            $card['founders'] = $founders;

            $managers = [];
            foreach ($companyInfo['Руковод'] as $manager) {
                array_push($managers, [
                    "inn" => $manager['ИНН'],
                    "name" => $manager['ФИО'],
                    "post" => $manager['НаимДолжн'],
                    "start_date" => Carbon::create($manager['ДатаЗаписи'])->timestamp,
                ]);
            }
            $card['managers'] = $managers;
        }

        return $card;
    }

    private function request(string $method, array $params)
    {
        return json_decode(file_get_contents("https://api.checko.ru/v2/$method?key={$this->apiKey}&" . http_build_query($params)), true);
    }
}
