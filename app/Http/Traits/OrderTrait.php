<?php

namespace App\Http\Traits;

use App\Http\Traits\Tinkoff;

use App\Models\Order;

trait OrderTrait
{
    use Tinkoff;

    public function storeOrder($request)
    {
        switch ($request->method) {
            case 'card':
                return $this->card($request);

            case 'qr':
                return $this->qr($request);

            case 'invoice':
                return $this->invoice($request);
        }
    }

    private function card($request)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'amount' => $request->amount
        ]);

        $res = $this->payInit($order);

        $order->token = $res['token'];

        $response = $res['res'];

        if (!$response->Success) {
            $order->status = $response->Message;
            $order->save();

            return back()->withErrors(['forbidden' => __('Payment service error. Please try again in a couple of minutes')]);
        }

        $order->status = $response->Status;
        $order->save();

        return redirect($response->PaymentURL);
    }

    private function qr()
    {
        return view('order.qr');
    }

    private function invoice()
    {
        return view('order.invoice');
    }
}
