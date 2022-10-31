<?php

namespace App\Rules\Delegation;

use App\Services\Delegations\DelegationService;
use Illuminate\Contracts\Validation\Rule;

class DelegationLimitRule implements Rule
{
    /**
     * @var DelegationService
     */
    private DelegationService $delegationService;

    /**
     * @param  DelegationService  $delegationService
     */
    public function __construct(
        DelegationService $delegationService
    ) {
        $this->delegationService = $delegationService;
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return ! $this->delegationService->isDelegationLimitExceeded($value);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'This employee is currently on delegation.';
    }
}
