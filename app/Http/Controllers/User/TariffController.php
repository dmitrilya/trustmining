<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\User\Tariff;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tariff.index', ['tariffs' => Tariff::all()]);
    }

    /**
     * Display a listing of the resource.
     *
     * \App\Models\User\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function show(Tariff $tariff)
    {
        return view('tariff.show', ['tariff' => $tariff]);
    }
}
