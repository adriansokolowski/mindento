<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationTrait
{
    /**
     * @param  Validator  $validator
     * @return array
     */
    protected function failedValidation(Validator $validator): array
    {
        $response = [
            'status' => 'error',
            'status_code' => 422,
            'errors' => $validator->errors(),
        ];
        $e = response()->json($response, 422);

        throw new HttpResponseException($e);
    }
}
