<?php

namespace App\Http\Traits;

use Exception;

trait YandexGPT
{
    public function checkTextWithPrompt($text)
    {
        $params = [
            'modelUri' => 'cls://' . config('services.yandexgpt.folder') . '/yandexgpt-lite',
            'text' => $text,
            'task_description' => 'Определи наличие в тексте нецензурной лексики, ругательств, матерных слов или упоминание имён известных личностей',
            'labels' => [
                'спам'
            ]
        ];

        return $this->request('POST', 'https://llm.api.cloud.yandex.net/foundationModels/v1/fewShotTextClassification', $params);
    }

    public function checkTextTuned($text)
    {
        $params = [
            'modelUri' => 'cls://' . config('services.yandexgpt.folder') . '/yandexgpt-lite',
            'text' => $text,
        ];

        return $this->request('POST', 'https://llm.api.cloud.yandex.net:443/foundationModels/v1/textClassification', $params);
    }

    public function checkReviewWithPrompt($text)
    {
        $params = [
            'modelUri' => 'cls://' . config('services.yandexgpt.folder') . '/yandexgpt-lite',
            'text' => $text,
            'task_description' => 'Определи вероятность того что отзыв является ненастоящим, заказным, фальшивым',
            'labels' => [
                'спам'
            ]
        ];

        return $this->request('POST', 'https://llm.api.cloud.yandex.net/foundationModels/v1/fewShotTextClassification', $params);
    }

    public function checkDocument($text)
    {
        $params = [
            'modelUri' => 'gpt://' . config('services.yandexgpt.folder') . '/yandexgpt',
            "completionOptions" => [
                "stream" => false,
                "temperature" => 0.1,
                "maxTokens" => "2000",
                "reasoningOptions" => [
                    "mode" => "DISABLED"
                ]
            ],
            "messages" => [
                [
                    "role" => "system",
                    "text" => "Представлен договор на оказание услуг. Нужно внимательно пройтись по всем пунктам и найти все риски для заказчика. Все замечания нужно представить в виде массива на языке php с тремя вложенными массивами 1) То что может повлечь за собой утерю оборудования заказчиком или другие материальные или финансовые потери, 2) Неточности описания условий договора которые могут привести к спорам, 3) Наличие ошибок в тексте или отклонение от стандартов составления договоров"
                ],
                [
                    "role" => "user",
                    "text" => $text
                ]
            ]
        ];

        return $this->request('POST', 'https://llm.api.cloud.yandex.net/foundationModels/v1/completionAsync', $params);
    }

    private function request($method, $link, $params)
    {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Api-Key ' . config('services.yandexgpt.key'),
                'Content-Type: application/json',
                'x-folder-id: ' . config('services.yandexgpt.folder')
            ]);

            if ($method == 'POST') curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

            $out = curl_exec($curl);

            if ($out === false) throw new Exception(curl_error($curl), curl_errno($curl));

            curl_close($curl);

            return json_decode($out);
        } catch (Exception $e) {
            dd($e->getCode(), $e->getMessage());
        } finally {
            if (is_resource($curl)) curl_close($curl);
        }
    }
}
