<?php

namespace App\Services\Delegations;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Employee;

class EmployeeService
{
    /**
     * @var Employee
     */
    private Employee $employee;

    /**
     * @param  Employee  $employee
     */
    public function __construct(
        Employee $employee
    ) {
        $this->employee = $employee;
    }

    /**
     * @param  StoreEmployeeRequest  $request
     * @return Employee
     */
    public function storeEmployee(StoreEmployeeRequest $request): Employee
    {
        $validatedData = $request->validated();

        return $this->employee->create(
            $validatedData
        );
    }
}
