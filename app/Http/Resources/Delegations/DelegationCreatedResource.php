<?php

namespace App\Http\Resources\Delegations;

use Illuminate\Http\Resources\Json\JsonResource;

class DelegationCreatedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'start' => $this->resource->start,
            'end' => $this->resource->end,
            'employee_id' => $this->resource->employee_id,
            'country' => $this->resource->country,
        ];
    }
}
