<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Jobs\TokenNull;
use App\Models\Ad\Hosting;
use App\Models\User\User;
use App\Models\DailyHostingProfit;
use Carbon\Carbon;
use Illuminate\Support\Str;

trait YooKassaTrait
{
    public function yookassa_sbp($amount, $paymentId)
    {
        $data = [
            'payment_method_data' => [
                'type' => "sbp"
            ],
            'confirmation' => [
                'type' => "qr"
            ],
            'amount' => [
                "value" => $amount,
                "currency" => "RUB"
            ],
            //'payment_id' => Str::random(32),
            'description' => "$paymentId",
            'capture' => true
        ];

        return $this->UCassaRequest($data, 'POST', "v3/payments");
    }

    public function UCassaRequest($data, $method, $url)
    {
        $token = $this->generate_uuid();
        $link = "https://api.yookassa.ru/$url";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_USERPWD, env('YOOKASSA_SHOPID') . ":" . env('YOOKASSA_SECRET'));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Idempotence-Key: ' . $token, 'Content-Type: application/json'));
        //curl_setopt($curl,CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        if ($method == 'POST') curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));

        $out = curl_exec($curl);

        curl_close($curl);

        return json_decode($out);
    }

    private function buildQuery_ucassa(array $params)
    {
        $query_array = array();

        foreach ($params as $key => $value) {
            if (is_array($value)) $query_array = array_merge($query_array, array_map(function ($v) use ($key) {
                return urlencode($key) . '=' . urlencode($v);
            }, $value));
            else $query_array[] = urlencode($key) . '=' . urlencode($value);
        }

        return implode('&', $query_array);
    }

    function generate_uuid($data = null)
    {
        $data = $data ?? random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
