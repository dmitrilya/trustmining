<?php

namespace App\Http\Traits;

use App\Http\Traits\Tinkoff;

use App\Models\Order;

trait OrderTrait
{
    use Tinkoff;

    public function storeOrder($request)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'amount' => $request->amount,
            'method' => $request->method
        ]);

        $res = $this->payInit($order);
        $order->token = $res['token'];
        $response = $res['res'];

        if (!$response->Success) {
            info(json_encode($response));
            
            $order->status = $response->Message;
            $order->save();

            return back()->withErrors(['forbidden' => __('Payment service error. Please try again in a couple of minutes')]);
        }

        $order->status = $response->Status;
        $order->save();

        switch ($request->method) {
            case 'card':
                return redirect($response->PaymentURL);

            case 'qr':
                return redirect($this->getQr($response->PaymentId)['res']->Data);

            case 'invoice':
                return $this->invoice($order);
        }
    }

    public function updateOrder($request)
    {
        $order = Order::find($request->OrderId);

        $tokenData = $request->except('Token');
        $tokenData['Success'] = $tokenData['Success'] ? "true" : "false";

        if (!$order || $order->status == 'CONFIRMED' || $request->Token != $this->token($tokenData)) return;

        $order->status = $request->Status;
        $order->save();

        if ($order->status == 'CONFIRMED') {
            $order->user->balance += $order->amount;
            $order->user->save();
        }

        return;
    }

    private function invoice($order)
    {
        return view('order.invoice');
    }
}
