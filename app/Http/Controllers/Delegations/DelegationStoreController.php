<?php

namespace App\Http\Controllers\Delegations;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDelegationRequest;
use App\Http\Resources\Delegations\DelegationCreatedResource;
use App\Services\Delegations\DelegationService;
use Illuminate\Http\JsonResponse;

class DelegationStoreController extends Controller
{
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
     * @param  StoreDelegationRequest  $request
     * @return JsonResponse
     */
    public function storeDelegation(StoreDelegationRequest $request): JsonResponse
    {
        $delegation = $this->delegationService->storeDelegation($request);

        return $this->responseSuccess(['delegation' => new DelegationCreatedResource($delegation)]);
    }
}
