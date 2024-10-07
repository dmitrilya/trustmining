<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;

use App\Http\Traits\OrderTrait;

class OrderController extends Controller
{
    use OrderTrait;

    public function create()
    {
        return view('order.create');
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
}
