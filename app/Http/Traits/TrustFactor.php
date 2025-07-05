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
            if ($user->company->card['type'] == 'LEGAL') {
                $tf += 3;

                if ($user->company->card['capital'] == 10000) $tf -= 4;
                if ($user->company->card['branch_count'] > 0) $tf += 3;
            }

            $diffYears = Carbon::now()->diffInYears(Carbon::createFromTimestampMs($user->company->card['state']['registration_date']));
            if ($diffYears > 3) $tf += 5;
            elseif ($diffYears > 2) $tf += 2;
            elseif ($diffYears < 1) $tf -= 3;

            if ($user->company->card['state']['status'] != 'ACTIVE') $tf -= 35;

            if ($user->company->card['finance']) {
                if ($user->company->card['finance']['income'] > 10000000000) $tf += 7;
                elseif ($user->company->card['finance']['income'] > 5000000000) $tf += 5;
                elseif ($user->company->card['finance']['income'] > 2000000000) $tf += 3;
                elseif ($user->company->card['finance']['income'] < 100000000) $tf -= 6;
                elseif ($user->company->card['finance']['income'] < 1000000000) $tf -= 3;
            }

            if ($user->company->card['employee_count'] > 10) $tf += 4;
            elseif ($user->company->card['employee_count'] > 4) $tf += 2;
            elseif ($user->company->card['employee_count'] > 1) $tf += 1;
            else $tf -= 5;

            if ($user->company->card['invalid']) $tf -= 15;
        }

        if ($user->moderatedReviews->count() > 3) {
            $avgRating = $user->moderatedReviews->avg('rating');
            if ($avgRating >= 4.85) $tf += 7;
            elseif ($avgRating >= 4.7) $tf += 4;
            elseif ($avgRating >= 4.4) $tf += 1;
            elseif ($avgRating >= 4.1) $tf -= 3;
            elseif ($avgRating >= 3.9) $tf -= 6;
            elseif ($avgRating >= 3.65) $tf -= 10;
            else $tf -= 15;
        }

        $tfForOffices = [0, 0, 4, 6, 8, 10, 11, 12];
        $tf += $tfForOffices[$user->moderatedOffices->count()];

        $uniqueContent = $user->ads->where('unique_content')->count() / $user->ads->count();
        if ($uniqueContent >= 0.9) $tf += 5;
        elseif ($uniqueContent >= 0.75) $tf += 2;
        elseif ($uniqueContent < 0.15) $tf -= 5;
        elseif ($uniqueContent < 0.5) $tf -= 2;

        if ($user->art < 5) $tf += 4;
        elseif ($user->art < 10) $tf += 2;
        elseif ($user->art > 40) $tf -= 4;
        elseif ($user->art > 20) $tf -= 2;

        if ($tf > 100) $tf = 100;
        elseif ($tf < 0) $tf = 0;

        $user->tf = $tf;
        $user->save();

        return true;
    }
}
