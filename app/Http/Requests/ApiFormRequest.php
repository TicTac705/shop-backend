<?php

namespace App\Http\Requests;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

trait ApiFormRequest
{
    /**
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], HTTPResponseStatuses::UNPROCESSABLE_ENTITY));
    }
}
