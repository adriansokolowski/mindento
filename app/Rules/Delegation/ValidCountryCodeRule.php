<?php

namespace App\Rules\Delegation;

use App\Services\Utils\ConstService;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidCountryCodeRule implements InvokableRule
{
    /**
     * @var bool
     */
    public bool $implicit = true;

    /**
     * @param $attribute
     * @param $value
     * @param $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $exists = array_key_exists($value, ConstService::AVAILABLE_ALPHA2_COUNTRIES_ARRAY);

        if ($exists === false) {
            $fail('The :attribute must be ISO 3166-1 alpha-2 format.');
        }
    }
}
