<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;

use App\Http\Traits\OrderTrait;

use App\Models\User\Order;

class OrderController extends Controller
{
    use OrderTrait;

    public function create()
    {
        return view('order.create', ['user' => Auth::user()]);
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
        if ($request->token != '5026378f48457ae81c43e1c70a51a003754972b8710ebac9ccd42975c1fe75d2') return;

        $order = Order::where('invoice_id', $request->invoiceId)->with(['user:id,balance', 'user.company:id,user_id,card,moderation'])->first();

        $operations = $this->getOperations(['from' => $order->created_at->format('Y-m-d\Th:i:s\Z'), 'inns' => [$order->user->company->card['inn']]]);

        if (!count($operations)) $order->update(['status' => 'INVALID_PAYER']);
        else {
            $order->update(['status' => 'CONFIRMED']);

            if ($order->method == 'invoice_verification') $order->user->company->update(['moderation' => false]);
            else $order->user->update(['balance' => $order->user->balance + $order->amount]);
        }

        echo 'OK';
    }
}
