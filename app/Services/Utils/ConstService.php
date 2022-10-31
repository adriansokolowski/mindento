<?php

namespace App\Services\Utils;

abstract class ConstService
{
    public const DEFAULT_PER_PAGE = 15;

    public const AVAILABLE_ALPHA2_COUNTRIES_ARRAY = [
        'PL' => [10, 'PLN'],
        'DE' => [50, 'EUR'],
        'GB' => [75, 'GBP'],
    ];
}
