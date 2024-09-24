<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use MoveMoveIo\DaData\Enums\Language;
use MoveMoveIo\DaData\Facades\DaDataAddress;

class DaDataController extends BaseController
{
    public function suggestions(Request $request)
    {
        return response()->json([
            'success' => true,
            'suggestions' => DaDataAddress::prompt($request->address, 10, Language::RU)['suggestions']
        ], 200);
    }
}
