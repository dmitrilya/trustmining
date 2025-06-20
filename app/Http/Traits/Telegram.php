<?php

namespace App\Http\Traits;

trait Telegram
{
    public function tgAuth($request)
    {
        $auth_data = $request->all();

        $check_hash = $auth_data['hash'];
        unset($auth_data['hash']);
        $data_check_arr = [];

        foreach ($auth_data as $key => $value) {
            $data_check_arr[] = $key . '=' . $value;
        }

        sort($data_check_arr);
        $data_check_string = implode("\n", $data_check_arr);
        $secret_key = hash('sha256', env('NOTIFICATION_BOT_TOKEN'), true);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);

        if (strcmp($hash, $check_hash) !== 0 || (time() - $auth_data['auth_date']) > 86400) return redirect()->route('home');
        dd($auth_data);
        return $auth_data;
    }
}
