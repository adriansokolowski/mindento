<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Resources\Delegations\EmployeeCreatedResource;
use App\Services\Delegations\EmployeeService;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    /**
     * @var EmployeeService
     */
    private EmployeeService $employeeService;

    /**
     * @param  EmployeeService  $employeeService
     */
    public function __construct(
        EmployeeService $employeeService
    ) {
        $this->employeeService = $employeeService;
    }

    /**
     * @param  StoreEmployeeRequest  $request
     * @return JsonResponse
     */
    public function storeEmployee(StoreEmployeeRequest $request): JsonResponse
    {
        $employee = $this->employeeService->storeEmployee($request);

        return $this->responseSuccess(['employee' => new EmployeeCreatedResource($employee)]);
    }
}
