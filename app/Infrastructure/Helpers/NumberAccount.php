<?php

namespace App\Infrastructure\Helpers;

use App\Models\Account;

class NumberAccount
{
    public static function generate ()
    {
        $allNumbers = range(10000000, 99999999);
        $numbersExisting = Account::pluck('number')->toArray();
        $numbersAvailable = array_diff($allNumbers, $numbersExisting);
        shuffle($numbersAvailable);
        return array_shift($numbersAvailable);
    }
}
