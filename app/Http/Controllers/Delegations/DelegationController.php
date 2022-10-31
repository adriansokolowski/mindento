<?php

namespace App\Http\Controllers\Delegations;

use App\Http\Controllers\Controller;
use App\Http\Requests\DelegationRequest;
use App\Http\Resources\DelegationCollection;
use App\Services\Delegations\DelegationService;
use Illuminate\Http\JsonResponse;

class DelegationController extends Controller
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
     * @param  string  $employee_id
     * @param  DelegationRequest  $request
     * @return JsonResponse
     */
    public function getDelegations(string $employee_id, DelegationRequest $request): JsonResponse
    {
        $delegations = $this->delegationService->getDelegationsForEmployee($employee_id, $request);

        return $this->responseSuccess([new DelegationCollection($delegations)]);
    }
}
