<?php

namespace App\Http\Traits;

use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

        return back()->withErrors(['success' => __('You are logged in. Now you can subscribe to price updates')]);
    }

    public function tgDontAsk(Request $request)
    {
        $user = $request->user();

        if (!$user) return response()->json(['success' => false], 401);

        $user->tg_id = 0;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function tgSendNotifications(Collection $chatIds, $text, $keyboard = null)
    {
        $token = config('services.tgbot.token');
        $link = "https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);

        if ($keyboard) $link .= '&reply_markup=' . json_encode(['inline_keyboard' => $keyboard]);

        $chatIds->each(function ($chatId) use ($link) {
            try {
                $link .= "&chat_id=$chatId";
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_URL, $link);

                if (($out = curl_exec($curl)) === false || !json_decode($out)->ok)
                    info('CURL Error - Telegram->tgSendNotification: ' . $out . ' ' . curl_error($curl) . ' ' . curl_errno($curl));

                curl_close($curl);
            } catch (Exception $e) {
                info('Exception - Telegram->tgSendNotification: ' . $e->getMessage());
            } catch (Error $e) {
                info('Error - Telegram->tgSendNotification: ' . $e->getMessage());
            } finally {
                curl_close($curl);
            }
        });

        return true;
    }
}
