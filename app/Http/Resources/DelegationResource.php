<?php

namespace App\Http\Resources;

use App\Services\Delegations\DelegationService;
use Illuminate\Http\Resources\Json\JsonResource;

class DelegationResource extends JsonResource
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
            'country' => $this->resource->country ?? 'N/A',
            'amount_due' => DelegationService::getAmountDue($this->resource->country, $this->resource->start, $this->resource->end) ?? 0,
            'currency' => DelegationService::getCurrency($this->resource->country) ?? 'N/A',
        ];
    }
}
