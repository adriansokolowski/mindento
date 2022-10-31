<?php

use App\Http\Controllers\Delegations\DelegationController;
use App\Http\Controllers\Delegations\DelegationStoreController;
use App\Http\Controllers\Employees\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'employees'], function () {
    Route::post('store', [EmployeeController::class, 'storeEmployee']);
    // . . .
});
Route::group(['prefix' => 'delegations'], function () {
    Route::get('{employee_id}/list', [DelegationController::class, 'getDelegations'])
        ->whereUuid('employee_id');
    Route::post('store', [DelegationStoreController::class, 'storeDelegation']);
    // . . .
});
