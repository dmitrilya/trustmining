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

    public function companyByInn(string|int $inn, ?string $type = null): ?array
    {
        $inn = (string) $inn;

        $info = $this->getCompanyInfo($inn, $type);

        if ($info === null) return null;

        $finance = $this->getCompanyFinance($inn);
        $legasCases = $this->getCompanyLegalCases($inn);

        return $this->processData($info, $finance, $legasCases);
    }

    public function getCompanyInfo(string $inn, ?string $type): ?array
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

    public function getCompanyLegalCases(string $inn): ?array
    {
        return $this->request('legal-cases', ['inn' => $inn, 'role' => 'defendant', 'actual' => true])['data'] ?? null;
    }

    private function processData(array $companyInfo, ?array $finance, ?array $legalCases): array
    {
        $risks = array_filter([
            "ЕФРСБ" => !empty($companyInfo["ЕФРСБ"]),
            "НедобПост" => $companyInfo["НедобПост"] ?? false,
            "ДисквЛица" => $companyInfo["ДисквЛица"] ?? false,
            "МассРуковод" => $companyInfo["МассРуковод"] ?? false,
            "МассУчред" => $companyInfo["МассУчред"] ?? false,
            "НелегалФин" => $companyInfo["НелегалФинСтатус"] ?? null,
            "Санкции" => $companyInfo['СанкцииСтраны'] ?? [],
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
            "address" => $companyInfo['type'] == 'LEGAL' ? $companyInfo['ЮрАдрес']['АдресРФ'] : $companyInfo['Регион']['Наим'] . (isset($companyInfo['ОКТМО']['Наим']) ? ', ' . $companyInfo['ОКТМО']['Наим'] : ''),
            "finance" => [
                "income" => $finance['2110'] ?? null,
                "profit" => $finance['2400'] ?? null
            ],
            "risks" => $risks,
            "branch_count" => count($companyInfo['Подразд']['Филиал'] ?? []),
            "employee_count" => $companyInfo['СЧР'] ?? null,
            "legal_cases" => [
                'count' => $legalCases['ЗапВсего'] ?? null,
                'sum' => $legalCases['ОбщСуммИск'] ?? null,
            ]
        ];

        if ($companyInfo['type'] == 'LEGAL') {
            $card['kpp'] = $companyInfo['КПП'];
            $card['capital'] = $companyInfo['УстКап']['Сумма'] ?? null;

            $founders = [];
            foreach (($companyInfo['Учред']['ФЛ'] ?? []) as $founder) {
                array_push($founders, [
                    "inn" => $founder['ИНН'],
                    "name" => $founder['ФИО'],
                    "share" => $founder['Доля']['Процент'] ?? null,
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

        return [
            'name' => $companyInfo['type'] == 'LEGAL' ? $companyInfo['НаимСокр'] : $companyInfo['ТипСокр'] . ' ' . $companyInfo['ФИО'],
            'card' => $card
        ];
    }

    private function request(string $method, array $params)
    {
        return json_decode(file_get_contents("https://api.checko.ru/v2/$method?key={$this->apiKey}&" . http_build_query($params)), true);
    }
}
