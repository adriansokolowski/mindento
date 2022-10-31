<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Delegation extends Model
{
    use HasFactory;

    protected $table = 'delegations';

    protected $dates = [
        'start',
        'end',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'start',
        'end',
        'country',
        'employee_id',
    ];

    /**
     * @param $value
     * @return string|null
     */
    public function getStartAttribute($value): ?string
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('constants.date_format').' '.config('constants.time_format')) : null;
    }

    /**
     * @param $value
     * @return void
     */
    public function setStartAttribute($value): void
    {
        $this->attributes['start'] = $value ? Carbon::createFromFormat(config('constants.date_format').' '.config('constants.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    /**
     * @param $value
     * @return string|null
     */
    public function getEndAttribute($value): ?string
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('constants.date_format').' '.config('constants.time_format')) : null;
    }

    /**
     * @param $value
     * @return void
     */
    public function setEndAttribute($value): void
    {
        $this->attributes['end'] = $value ? Carbon::createFromFormat(config('constants.date_format').' '.config('constants.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    /**
     * @param  DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @return HasOne
     */
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }
}
