<?php

namespace App\Http\Requests;

use App\Rules\Delegation\DelegationLimitRule;
use App\Rules\Delegation\ValidCountryCodeRule;
use App\Services\Delegations\DelegationService;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreDelegationRequest extends FormRequest
{
    use ValidationTrait;

    /**
     * @param  DelegationService  $delegationService
     * @return array
     */
    public function rules(DelegationService $delegationService): array
    {
        return [
            'start' => [
                'required',
                'after:now',
                'date_format:'.config('constants.date_format').' '.config('constants.time_format'),
            ],
            'end' => [
                'required',
                'after:start',
                'date_format:'.config('constants.date_format').' '.config('constants.time_format'),
            ],
            'country' => ['required', new ValidCountryCodeRule()],
            'employee_id' => ['required', 'uuid', new DelegationLimitRule($delegationService)],
        ];
    }
}
