<?php

namespace App\Exceptions;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => $this->getMessage()], HTTPResponseStatuses::NOT_FOUND);
    }
}
