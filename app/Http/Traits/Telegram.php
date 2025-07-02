<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait Telegram
{
    public function tgAuth(Request $request)
    {
        $data = $request->all();

        $check_hash = $data['hash'];
        unset($data['hash']);
        $data_check_arr = [];

        foreach ($data as $key => $value) {
            $data_check_arr[] = $key . '=' . $value;
        }

        sort($data_check_arr);
        $data_check_string = implode("\n", $data_check_arr);
        $secret_key = hash('sha256', env('NOTIFICATION_BOT_TOKEN'), true);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);

        if (strcmp($hash, $check_hash) !== 0 || (time() - $data['auth_date']) > 86400)
            return back()->withErrors(['forbidden' => __('Authorization error. Try again')]);

        $user = $request->user();
        if (!$user) return back()->withErrors(['forbidden' => __('Authorization error. Try again')]);

        $user->tg_id = $data['id'];
        $user->save();

        return back();
    }
}
