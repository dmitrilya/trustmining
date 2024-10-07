<?php

namespace App\Http\Traits;

use App\Models\Payment;

trait Tinkoff
{
    public function payInit($order)
    {
        $params = [
            'Amount' => $order->amount * 100,
            'OrderId' => $order->id
        ];

        return $this->request('POST', 'Init', $params);
    }

    private function request($method, $link, $params)
    {
        $params['TerminalKey'] = '1727865557366DEMO';
        $params['Token'] = $this->token($params);

        $link = 'https://securepay.tinkoff.ru/v2/' . $link;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        if ($method == 'POST') curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

        $out = curl_exec($curl);
        curl_close($curl);

        return [
            'token' => $params['Token'],
            'res' => json_decode($out)
        ];
    }

    private function token($params)
    {
        $params['Password'] = '$6X*_dtr*MuxTajY';

        ksort($params);

        return hash('sha256', implode('', array_values($params)));
    }
}
