<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\User\Office;

trait OfficeTrait
{
    public function getOffices($request = null)
    {
        $offices = Office::where('moderation', false)->with('user:id,name,url_name,tf');

        if (isset($request)) {
            if ($request->peculiarities && count($request->peculiarities))
                $offices = $offices->whereJsonContains('peculiarities', $request->peculiarities);

            if ($request->city) $offices = $offices->where('address', 'like', '%' . $request->city . '%');
        }

        return $offices;
    }
}
