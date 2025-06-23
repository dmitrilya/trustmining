<?php

namespace App\Http\Traits;

trait TrustFactor
{
    public function calculateTrustFactor($user)
    {
        $tf = 50;

        $user->tf = $tf;
        $user->save();

        return true;
    }
}
