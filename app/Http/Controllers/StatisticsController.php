<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\StatisticsTrait;

class StatisticsController extends Controller
{
    use StatisticsTrait;

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ads()
    {
        return view('statistics.ads.index');
    }
}
