<?php

namespace App\Exceptions\Basket;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BasketEmptyException extends Exception
{
    protected $message = 'Basket is empty.';

    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => $this->getMessage()], HTTPResponseStatuses::NOT_FOUND);
    }
}
