<?php

namespace App\Http\Traits;

use App\Jobs\GetYandexGPTOperation;

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
            'modelUri' => 'cls://' . config('services.yandexgpt.folder') . '/yandexgpt',
            'text' => $text,
            'task_description' => 'Представлен отзыв о компании, которая занимается продажей оборудования для майнинга и размещением у себя на площадке. Определи, является ли данный отзыв фальшивым, учитывая уместность отзыва для компании и признаки: 1) Чрезмерная положительность, 2) Отсутствие конкретики, 3) Неестественный язык, 4) Слишком короткий или слишком длинный текст, 5) Отсутствие информации о личном опыте, 6) Наличие контактных данных, 7) Использование ключевых слов',
            'labels' => [
                'Фальшивый',
                'Настоящий',
                'Оскорбительный'
            ]
        ];

        return collect($this->request('POST', 'https://llm.api.cloud.yandex.net/foundationModels/v1/fewShotTextClassification', $params)->predictions)->sortByDesc('confidence')->first();
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
                    "text" => 'Представлен договор на оказание услуг. Нужно внимательно пройтись по всем пунктам договора и найти все риски для заказчика. 1) То что может повлечь за собой утрату оборудования заказчиком или другие материальные или финансовые потери, 2) Неточности описания условий договора которые могут привести к спорам, 3) Наличие ошибок в тексте или отклонение от стандартов составления договоров. Ответ предоставь в формате [Тут три массива по каждому пункту выше, но без текста в формате {"point": "Номер пункта договора", "problem": "Проблема"}'
                ],
                [
                    "role" => "user",
                    "text" => $text
                ]
            ]
        ];

        return $this->request('POST', 'https://llm.api.cloud.yandex.net/foundationModels/v1/completionAsync', $params);
    }

    public function getOperation($id)
    {
        $operation = $this->request('GET', 'https://operation.api.cloud.yandex.net/operations/' . $id);

        if (!$operation->done) return GetYandexGPTOperation::dispatch($id)->delay(now()->addMinutes(1));

        if (isset($operation->response)) return $operation->response;

        return false;
    }

    private function request($method, $link, $params = null)
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
            info('YandexGPT Exception ' . $e->getCode() . ' ' . $e->getMessage());
        } finally {
            if (is_resource($curl)) curl_close($curl);
        }
    }
}
