<?php

namespace App\Http\Traits;

use App\Models\Payment;

use Carbon\Carbon;

trait Tinkoff
{
    public function payInit($order)
    {
        $params = [
            'Amount' => $order->amount * 100,
            'OrderId' => $order->id,
            'Receipt' => [
                'Items' => [
                    [
                        'Name' => 'Пополнение баланса личного кабинета',
                        'Price' => $order->amount * 100,
                        'Quantity' => 1,
                        'Amount' => $order->amount * 100,
                        'PaymentObject' => 'service',
                        'Tax' => 'none',
                    ],
                ],
                'Email' => $order->user->email,
                'Taxation' => 'usn_income'
            ]
        ];

        return $this->tinkoffRequest('POST', 'Init', $params);
    }

    public function getQr($paymentId)
    {
        $params = [
            'PaymentId' => $paymentId
        ];

        return $this->tinkoffRequest('POST', 'GetQr', $params);
    }

    public function invoice($order)
    {
        $params = [
            'invoiceNumber' => "$order->id",
            'dueDate' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'payer' => [
                'name' => $order->user->company->name,
                'inn' => $order->user->company->card['inn'],
            ],
            'items' => [[
                'name' => 'Пополнение баланса личного кабинета',
                'price' => $order->amount,
                'unit' => 'шт',
                'vat' => 'None',
                'amount' => 1
            ]],
            'contacts' => [[
                'email' => $order->user->email
            ]],
            'customPaymentPurpose' => 'Пополнение баланса личного кабинета'
        ];

        if ($order->user->company->card['type'] == 'LEGAL') $params['payer']['kpp'] = $order->user->company->card['kpp'];

        return $this->tinkoffBusinessRequest('POST', 'invoice/send', $params);
    }

    public function getInvoice($invoiceId)
    {
        return $this->tinkoffBusinessRequest('GET', "openapi/invoice/$invoiceId/info");
    }

    public function getOperations($params)
    {
        $q = '?accountNumber=' . config('services.tinkoff.account_number') . '&from=' . $params['from'];
        
        foreach ($params['inns'] as $inn) {
            $q .= '&inns=' . $inn;
        }
        
        return $this->tinkoffBusinessRequest('GET', 'statement' . $q)->operations;
    }

    private function tinkoffRequest($method, $link, $params)
    {
        $params['TerminalKey'] = config('services.tinkoff.terminal.key');
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

    private function tinkoffBusinessRequest($method, $link, $params = null)
    {
        $link = 'https://business.tbank.ru/openapi/api/v1/' . $link;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer ' . config('services.tinkoff.key')]);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        if ($method == 'POST') curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

        $out = curl_exec($curl);
        curl_close($curl);

        return json_decode($out);
    }

    private function token($params)
    {
        $params['Password'] = config('services.tinkoff.terminal.password');

        ksort($params);

        return hash('sha256', implode('', array_values(array_diff_key($params, ['Receipt' => 0]))));
    }
}
