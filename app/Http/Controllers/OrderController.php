<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;

use App\Http\Traits\OrderTrait;

use App\Models\Order;

class OrderController extends Controller
{
    use OrderTrait;

    public function create()
    {
        return view('order.create', ['user' => \Auth::user()]);
    }

    public function store(StoreOrderRequest $request)
    {
        return $this->storeOrder($request);
    }

    public function webhook(Request $request)
    {
        $this->updateOrder($request);

        echo 'OK';
    }

    function invoiceWebhook(Request $request)
    {
        $order = Order::where('invoice_id', $request->invoiceId)->first();
        $order->update(['status' => 'CONFIRMED']);

        if ($order->amount == 10 && $order->user->company && $order->user->company->moderation) $order->user->company->update(['moderation' => false]);

        echo 'OK';
    }
}
