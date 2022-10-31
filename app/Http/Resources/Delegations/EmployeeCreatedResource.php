<?php

namespace App\Http\Resources\Delegations;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeCreatedResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'uuid' => $this->resource->uuid,
        ];
    }
}
