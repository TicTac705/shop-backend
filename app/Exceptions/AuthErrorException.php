<?php

namespace App\Exceptions;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthErrorException extends Exception
{
    protected $message = 'Your credentials are incorrect';

    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => $this->getMessage()], HTTPResponseStatuses::INCORRECT_CREDENTIALS);
    }
}
