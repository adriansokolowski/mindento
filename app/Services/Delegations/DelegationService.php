<?php

namespace App\Services\Delegations;

use App\Http\Requests\DelegationRequest;
use App\Http\Requests\StoreDelegationRequest;
use App\Models\Delegation;
use App\Models\Employee;
use App\Services\Utils\ConstService;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class DelegationService
{
    private Delegation $delegation;

    private Employee $employee;

    public const WORKDAY_START_HOUR = 8;

    public const WORKDAY_END_HOUR = 16;

    public const WORKDAY_SECONDS = (self::WORKDAY_END_HOUR - self::WORKDAY_START_HOUR) * 3600;

    public const HOLIDAYS = [];

    public const WEEKEND_DAYS = ['Saturday', 'Sunday'];

    public const DAYS_AFTER_DOUBLE_RATE = 7;

    /**
     * @param  Delegation  $delegation
     * @param  Employee  $employee
     */
    public function __construct(
        Delegation $delegation,
        Employee $employee,
    ) {
        $this->delegation = $delegation;
        $this->employee = $employee;
    }

    /**
     * @param  string  $employee_id
     * @param  DelegationRequest  $request
     * @return LengthAwarePaginator
     */
    public function getDelegationsForEmployee(string $employee_id, DelegationRequest $request): LengthAwarePaginator
    {
        $perPage = (int) $request->get('per_page', ConstService::DEFAULT_PER_PAGE);

        return $this->delegation
            ->where('employee_id', '=', $employee_id)
            ->paginate($perPage);
    }

    /**
     * @param  StoreDelegationRequest  $request
     * @return Delegation
     */
    public function storeDelegation(StoreDelegationRequest $request): Delegation
    {
        $validatedData = $request->validated();
        $employee = $this->employee->where('uuid', '=', $validatedData['employee_id'])->firstOrFail();

        return $this->delegation->create(
            $validatedData
        );
    }

    /**
     * @param  string  $country
     * @param  string  $start
     * @param  string  $end
     * @return int
     */
    public static function getAmountDue(string $country, string $start, string $end): int
    {
        $tmpCost = ConstService::AVAILABLE_ALPHA2_COUNTRIES_ARRAY[$country][0];

        $tmpDays = static::getWorkingDays($start, $end);

        if ($tmpDays > self::DAYS_AFTER_DOUBLE_RATE) {
            $tmpDays -= self::DAYS_AFTER_DOUBLE_RATE;

            return ($tmpCost * self::DAYS_AFTER_DOUBLE_RATE) + ($tmpDays * ($tmpCost * 2));
        }

        return $tmpDays * $tmpCost;
    }

    /**
     * @param  string  $from
     * @param  string  $to
     * @return int
     */
    private static function getWorkingHours(string $from, string $to): int
    {
        $from = strtotime($from);
        $to = strtotime($to);
        $fromDate = date('Y-m-d', $from);
        $toDate = date('Y-m-d', $to);

        $workDayNumber = self::getWorkingDays($fromDate, $toDate) - 1;
        $workDayNumber = max($workDayNumber, 0);

        $startTimeInSeconds = date('H', $from) * 3600 + date('i', $from) * 60;
        $endTimeInSeconds = date('H', $to) * 3600 + date('i', $to) * 60;

        return ($workDayNumber * self::WORKDAY_SECONDS + $endTimeInSeconds - $startTimeInSeconds) / 86400 * 24;
    }

    /**
     * @param  string  $from
     * @param  string  $to
     * @return int
     */
    private static function getWorkingDays(string $from, string $to): int
    {
        $workDays = [];
        $i = 0;
        $current = $from;

        if ($current == $to) {
            $timestamp = strtotime($from);
            if (! in_array(date('l', $timestamp), self::WEEKEND_DAYS) && ! in_array(date('Y-m-d', $timestamp), self::HOLIDAYS)) {
                $days_array[] = date('Y-m-d', $timestamp);
            }
        } elseif ($current < $to) {
            while ($current < $to) {
                $timestamp = strtotime($from.' +'.$i.' day');
                if (! in_array(date('l', $timestamp), self::WEEKEND_DAYS) && ! in_array(date('Y-m-d', $timestamp), self::HOLIDAYS)) {
                    $workDays[] = date('Y-m-d', $timestamp);
                }
                $current = date('Y-m-d', $timestamp);
                $i++;
            }
        }

        return count($workDays);
    }

    /**
     * @param  string  $employee_id
     * @return bool
     */
    public function isDelegationLimitExceeded(string $employee_id): bool
    {
        $from = Carbon::now();
        $to = Carbon::now()->addYears(5);

        return $this->delegation->where('employee_id', $employee_id)->whereBetween('end', [$from, $to])->exists();
    }

    /**
     * @param  string  $country
     * @return string
     */
    public static function getCurrency(string $country): string
    {
        return ConstService::AVAILABLE_ALPHA2_COUNTRIES_ARRAY[$country][1];
    }
}
