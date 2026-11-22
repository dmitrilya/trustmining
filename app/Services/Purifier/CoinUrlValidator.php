<?php

namespace App\Services\Purifier;

use HTMLPurifier_AttrDef;

class CoinUrlValidator extends HTMLPurifier_AttrDef
{
    public function validate($string, $config, $context)
    {
        $string = $this->parseCDATA($string);

        $pattern = '%^--coin-url\s*:\s*url\(/storage/coins/[a-zA-Z0-9_\-]+\.webp\);?$%i';

        if (preg_match($pattern, trim($string))) {
            return $string;
        }

        return false;
    }
}
