<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait TrustFactor
{
    public function calculateTrustFactor($user)
    {
        $tf = 50;

        if (!$user->company) $tf -= 20;
        else {
            if ($user->company->card['type'] == 'LEGAL') $tf += 3;

            $diffYears = Carbon::now()->diffYears(Carbon::create($user->company->card['registration_date']));
            if ($diffYears > 4) $tf += 6;
            elseif ($diffYears > 2) $tf += 3;
            elseif ($diffYears < 1) $tf -= 3;

            
        }

        if ($user->moderatedReviews->count() > 3) {
            if ($user->avg_rating >= 4.85) $tf += 12;
            elseif ($user->avg_rating >= 4.7) $tf += 8;
            elseif ($user->avg_rating >= 4.5) $tf += 4;
            elseif ($user->avg_rating >= 4.3) $tf += 2;
            elseif ($user->avg_rating >= 4.05) $tf -= 5;
            elseif ($user->avg_rating >= 3.7) $tf -= 10;
            else $tf -= 15;
        }

        $tfForOffices = [0, 0, 3, 6, 9, 11, 13, 14];
        $tf += $tfForOffices[$user->moderatedOffices->count()];

        $user->tf = $tf;
        $user->save();

        return true;
    }
}
