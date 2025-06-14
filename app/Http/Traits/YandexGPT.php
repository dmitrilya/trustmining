<?php

namespace App\Http\Traits;

trait YandexGPT
{
    public function checkTextWithPrompt($text)
    {
        $params = [
            'modelUri' => 'cls://' . env('YANDEXGPT_FOLDER_ID') . '/yandexgpt-lite',
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
            'modelUri' => 'cls://' . env('YANDEXGPT_FOLDER_ID') . '/yandexgpt-lite',
            'text' => $text,
        ];

        return $this->request('POST', 'https://llm.api.cloud.yandex.net:443/foundationModels/v1/textClassification', $params);
    }

    private function request($method, $link, $params)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Api-Key ' . env('YANDEXGPT_APP_KEY')]);

        if ($method == 'POST') curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

        $out = curl_exec($curl);
        curl_close($curl);

        return [
            'result' => json_decode($out)
        ];
    }
}
