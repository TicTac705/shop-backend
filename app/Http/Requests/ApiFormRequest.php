<?php

namespace App\Http\Requests;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

trait ApiFormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], HTTPResponseStatuses::UNAUTHORIZED));
    }
}
